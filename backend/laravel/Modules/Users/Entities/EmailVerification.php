<?php

namespace Modules\Users\Entities;

use BadMethodCallException;
use Carbon\Carbon;
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Users\Entities\User;
use Modules\Users\Emails\EmailVerificationMail;

class EmailVerification extends Model
{
    const TABLE = 'auth_email_verifications';
    protected $table = EmailVerification::TABLE;

    protected $fillable = [
        'user_id',
        'send_to',
        'verfication_key',
        'is_active',
        'sent_at',
        'expired_at',
        'verified_at',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'sent_at'       => 'datetime',
        'expired_at'    => 'datetime',
        'verified_at'   => 'datetime',
    ];

    public $timestamps = false;

    /**
     *  ######################### Relationships #########################
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *  ######################### Private function #########################
     */

    /**
     * Generate a new EmailVerification instance
     *
     * @param User $user
     * @return EmailVerification instance
     */
    private static function __create(User $user)
    {
        $today = Carbon::now();

        // Generate unhashed verification key
        $key = strval(time()) . $user->email . $user->name . 'ccsw';

        $emailVerification = new EmailVerification();
        $emailVerification->user_id             = $user->id;
        $emailVerification->send_to             = $user->email;
        // Hash with sha1, can change hash method
        $emailVerification->verification_key    = sha1($key);
        $emailVerification->is_active           = true;
        $emailVerification->sent_at             = $today;
        $emailVerification->expired_at          = $today->addHours(config('auth.expiry_duration_hours'));
        $emailVerification->save();

        return $emailVerification;
    }

    /**
     * Send Email to User email
     *
     * @return void
     */
    private function __sendEmail()
    {
        Mail::to($this->send_to)->send(new EmailVerificationMail($this));
    }

    /**
     *  ######################### Public function #########################
     */

    /**
     * Override & disable basic @method create()
     * @throws BadMethodCallException
     */
    public static function create(array $attributes = [], array $options = [])
    {
        throw new BadMethodCallException('Method disabled');
    }

    /**
     * Override & disable basic @method update()
     * @throws BadMethodCallException
     */
    public function update(array $attributes = [], array $options = [])
    {
        throw new BadMethodCallException('Method disabled');
    }

    /**
     * Creates an EmailVerification instance, log all email verification details on database,
     * then proceeds to send the Verification mail.
     * Deletes existing email verification, only 1 verification key may be active at a time.
     *
     * @param mixed $userId
     * @return void
     */
    public static function sendEmailVerification($userId)
    {
        // Get user, or throw an exception on fail
        $user = User::findOrFail($userId);

        // If email has already been verified, do nothing
        if ($user->is_email_verified) {
            return;
        }

        // Use `DB::transaction()` so no partial data can be created or updated
        return DB::transaction(function () use ($user) {
            // If previous EmailVerification exist, delete it
            $emailVerification = EmailVerification::where([['send_to', $user->email], ['is_active', true]])->first();
            if ($emailVerification !== null) {
                $emailVerification->delete();
            }

            // Create new EmailVerification instance
            $emailVerification =  EmailVerification::__create($user);

            // Send Email, check with mailtrap.io for testing purposes
            $emailVerification->__sendEmail();
        });
    }

    /**
     * Verify Email with specific key generated in EmailVerification::sendEmailVerification()
     *
     * @param string $verificationKey
     * @return void
     */
    public static function verifyEmail(string $verificationKey)
    {
        $today = Carbon::now();

        // Validate if EmailVerification key exists
        $emailVerification = EmailVerification::where('verification_key', $verificationKey)->first();
        if ($emailVerification === null) {
            throw new ModelNotFoundException('Key does not exist');
        }

        // Check if EmailVerification is not expired
        if ($emailVerification->expired_at->isBefore($today)) {
            // If expired, delete
            $emailVerification->delete();
            throw new BadMethodCallException('Key is Expired');
        }

        // Validate whether key has been verified or not
        if (!$emailVerification->is_active) {
            throw new BadMethodCallException('Key is no longer active');
        }

        return DB::transaction(function () use ($emailVerification, $today) {
            $emailVerification->verified_at                 = $today;
            $emailVerification->is_active                   = false;
            $emailVerification->save();

            $emailVerification->user->is_email_verified     = true;
            $emailVerification->user->email_verified_at     = $today;
            $emailVerification->user->save();
        });
    }
}
