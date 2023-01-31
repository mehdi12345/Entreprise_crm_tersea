<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invite extends Mailable
{
    use Queueable, SerializesModels;

    public $company_name;
    public $name; //name of the employee
    public $auth; //name of the admin
    public $id; //id of the employee
    public $adminId; //id of the admin
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$auth,$id,$adminId)
    {
        $this->name=$name;
        $this->auth=$auth;
        $this->id=$id;
        $this->adminId=$adminId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('invite');
    }
}
