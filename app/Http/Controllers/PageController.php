<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CompletedProjectDetail;
use App\Models\OngoingProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function pitchbook()
    {
        $data = [
            'title' => 'PPP KP - Digital Pitchbook ' . date('Y'),
            'totalPages' => 80,
            'slideCount' => 80,
            'currentYear' => date('Y'),
            'companyName' => 'PPP KP',
            'email' => 'info@ppkp.com',
            'phone' => '+92 XXX XXXXXXX'
        ];
        
        return view('user.pitchbook', $data);
    }

    /**
     * API endpoint for downloading files
     */
    public function apiDownloadFile($id)
    {
        return response()->json(['success' => true]);
    }

    /**
     * API endpoint for previewing files
     */
    public function apiPreviewFile($id)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return view('user.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        // Log the request data
        Log::info('Contact form submitted', $request->all());

        // Validate the request
        $validated = $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            // Prepare data for emails
            $firstName = $validated['first-name'];
            $lastName = $validated['last-name'];
            $email = $validated['email'];
            $phone = $validated['phone'] ?? 'Not provided';
            $subject = $validated['subject'];
            $messageContent = $validated['message'];
            
            // Log mail configuration for debugging
            Log::info('Mail configuration:', [
                'mailer' => config('mail.mailer'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username'),
                'from' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
            ]);

            // Send email to admin - UPDATED PATH
            $adminEmail = 'ainakhan464@gmail.com'; // Your test email
            
            Mail::send('user.emails.contact', [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'messageContent' => $messageContent,
            ], function ($message) use ($adminEmail, $email, $firstName, $lastName, $subject) {
                $message->to($adminEmail, 'PPP Unit KP Admin')
                        ->subject('New Contact Form Submission: ' . $subject)
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->replyTo($email, $firstName . ' ' . $lastName);
            });

            Log::info('Admin email sent successfully to: ' . $adminEmail);

            // Send auto-reply to user - UPDATED PATH
            Mail::send('user.emails.contact-autoreply', [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
            ], function ($message) use ($email, $firstName, $lastName) {
                $message->to($email, $firstName . ' ' . $lastName)
                        ->subject('Thank You for Contacting PPP Unit KP')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Auto-reply email sent successfully to: ' . $email);

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully! We will get back to you soon.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send your message. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}