<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = ['name', 'slug', 'role', 'bio', 'photo', 'email', 'linkedin_url', 'status', 'sort_order'];


    protected function uploadedFileAttributes(): array
    {
        return ['photo'];
    }}
