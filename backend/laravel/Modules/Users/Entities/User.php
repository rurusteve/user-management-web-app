<?php

namespace Modules\Users\Entities;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE = 'users';
    protected $table = User::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_email_verified' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Users\Database\factories\UserFactory::new();
    }

    /**
     * Find User Instance by Email
     *
     * @param array $email     : user email
     * @return User instance
     */
    public static function findByEmail(string $email)
    {
        // Get user instance
        $user = User::where('email', $email)->first();

        if ($user == null) {
            $message = 'User does not exist';
            throw new ModelNotFoundException($message);
        }
        return $user;
    }

    /**
     * List Users
     *
     * @return array[User]
     */
    public static function list()
    {
        $user = User::all();

        return $user;
    }

    /**
     * Override the create function
     *
     * @param array @attributes with keys:
     *          - first_name (required)
     *          - last_name (required)
     *          - username (required)
     *          - password (required)
     *          - email
     *          - phone_number
     *
     * @return User instance
     */

    public static function create(array $attributes, array $options = []){

        $user = new User();
        $user -> first_name = $attributes['first_name'];
        $user -> last_name = $attributes['last_name'];
        $user -> username = $attributes['username'];
        $user -> password = Hash::make($attributes['password']);
        $user->fill($attributes)->save($options);
        return $user;

        // (TODO: Check if username, email, phone_number already exist to make it unique)
        // (TODO: Improve, make a trait to check each isset attributes)
     }

     /**
      * Change User Password
      *
      * @param string @password
      * @return void
      */

      public function updatePassword(string $password){
          $this->password = $password;
          $this->save();
      }

    /**
     * Login User, generate Authentication Token
     *
     * @param array @attributes with keys:
     *      - email
     *      - password
     * @return Token $token
     */
    public static function login(array $attributes)
    {
        // Get user instance
        $user = User::where('email', $attributes['email'])->first();

        // Check if password is correct
        if (!$user || !Hash::check($attributes['password'], $user->password)) {
            throw new BadMethodCallException('The provided credentials are incorrect.');
        }

        // Generate token
        $token = $user->createToken($user->id);

        return $token;
    }


}
