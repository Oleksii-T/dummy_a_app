<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Blog;
use Illuminate\Queue\SerializesModels;

class ShareBlog extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $blog;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $id)
    {
        $this->user = $user;
        $this->blog = Blog::find($id);
        $this->subject = 'Shared blog from ' . $user->full_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->markdown('emails.share-blog');
    }
}
