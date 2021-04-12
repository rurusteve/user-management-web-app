<?php

namespace Modules\Users\Entities;

use BadMethodCallException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Mail, DB, Hash};
use Modules\Users\Entities\User;
use Modules\Users\Emails\PasswordResetMail;

class PasswordReset extends Model
{
    const TABLE = 'auth_password_resets';
    protected $table = PasswordReset::TABLE;

    protected $fillable = [
        'user_id',
        'send_to',
        'reset_key',
        'sent_at',
        'expired_at',
        'changed_at',
        'is_active'
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
     * Generate a new Password Reset instance.
     *
     * @param User $user
     * @return PasswordReset instance on success
     */
    private static function __create(User $user)
    {
        $today = Carbon::now();


        // Generate unhashed verification key
        $key = strval(time()) . $user['email'] . 'ccsw';

        $passwordReset = new PasswordReset();
        $passwordReset->user_id             = $user->id;
        $passwordReset->send_to             = $user->email;
        // Hash verification key with sha1, can change hash method
        $passwordReset->reset_key           = sha1($key);
        $passwordReset->sent_at             = $today;
        $passwordReset->is_active           = true;
        $passwordReset->expired_at          = $today->addMinutes(config('auth.passwords.users.expire'));
        $passwordReset->save();

        return $passwordReset;
    }

    /**
     * Send Password Reset Email to associated email
     *
     * @return void
     */
    private function __sendEmail()
    {
        Mail::to($this->send_to)->send(new PasswordResetMail($this));
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
     * Creates a PasswordReset instance, log all password reset details on database,
     * then proceeds to send the Password Reset mail.
     * Deletes existing password reset, only 1 reset key may be active at a time.
     *
     * @return PasswordReset instance on success
     * Automatically rollbacks on error
     */
    public static function sendPasswordReset($userId)
    {
        // Get user, or throw an exception on fail
        $user = User::findOrFail($userId);

        // Use `DB::transaction()` so no partial data can be created or updated
        return DB::transaction(function () use ($user) {
            // If previous PasswordReset exist, disable it
            $passwordReset = PasswordReset::where([['send_to', $user->email], ['is_active', true]])->first();
            if ($passwordReset != null) {
                $passwordReset->delete();
            }

            // Create new PasswordReset instance
            $passwordReset = PasswordReset::__create($user);

            // Send Email, check with mailtrap.io for testing purposes
            $passwordReset->__sendEmail();

            return $passwordReset;
        });
    }

    /**
     * Verify password reset from user.
     *
     * @param array $attributes : must contain key
     *  - reset_key
     *  - password
     *  - password_confirmation
     * @return PasswordReset instance on success
     * @throws BadMethodCallException on error
     */
    public static function verifyPassword(array $attributes)
    {
        $today = Carbon::now();

        // Validate if Password Reset key is valid
        $passwordReset = PasswordReset::where([['reset_key', $attributes['reset_key']], ['is_active', true]])->first();
        if ($passwordReset === null) {
            throw new BadMethodCallException('Key does not exist');
        }

        // Check if PasswordReset is not expired
        if ($passwordReset->expired_at->isBefore($today)) {
            // If expired, delete
            $passwordReset->delete();
            throw new BadMethodCallException('Key is Expired');
        }

        // Validate whether key has been verified or not
        if (!$passwordReset->is_active) {
            throw new BadMethodCallException('Key is no longer active');
        }

        return DB::transaction(function () use ($passwordReset, $today, $attributes) {
            $passwordReset->changed_at      = $today;
            $passwordReset->is_active       = false;
            $passwordReset->save();

            $passwordReset->user->password  = Hash::make($attributes['password']);
            $passwordReset->user->save();

            return $passwordReset;
        });
    }
}
