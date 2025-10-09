<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // <- Ajouté

class Contact extends Model
{
    use HasFactory, Notifiable; // <- Ajouté Notifiable 
    protected $fillable = ['name', 'email', 'subject', 'message'];

}
