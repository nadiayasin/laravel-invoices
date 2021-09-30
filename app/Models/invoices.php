<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exports\invoicesExport;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{   
    use SoftDeletes;
    use HasFactory;
    protected $guarded=[];


    
public function section(){
    return $this->belongsTo(sections::class);
}

}
class User extends Authenticatable
{
    use Notifiable;
}