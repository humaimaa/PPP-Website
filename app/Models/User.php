<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
    
    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }
    
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }
    
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
    
    /**
     * Send the email verification notification - WORKING VERSION
     */
   /**
 * Send the email verification notification - WORKING VERSION
 */
public function sendEmailVerificationNotification()
{
    try {
        Log::info('Preparing to send verification email to: ' . $this->email);
        
        // Generate verification URL - USE THE CORRECT ROUTE NAME
        $verificationUrl = URL::temporarySignedRoute(
            'admin.verification.verify',  // Changed from 'verification.verify' to 'admin.verification.verify'
            Carbon::now()->addMinutes(60),
            [
                'id' => $this->id,
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );
        
        Log::info('Verification URL generated: ' . $verificationUrl);
        
        // Send email directly
        Mail::send('admin.verify-email', 
            [
                'name' => $this->name,
                'verificationUrl' => $verificationUrl,
                'email' => $this->email
            ], 
            function($message) {
                $message->to($this->email, $this->name)
                        ->subject('Verify Your Email Address - PPP Department KPK')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            }
        );
        
        Log::info('Verification email sent successfully to: ' . $this->email);
        
    } catch (\Exception $e) {
        Log::error('Failed to send verification email: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        throw $e;
    }
}
    
    public function getEmailForVerification()
    {
        return $this->email;
    }
}