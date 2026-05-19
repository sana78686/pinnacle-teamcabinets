<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
use HasFactory, Notifiable,  BelongsToTenant;

protected $guarded = [];
protected $connection = 'tenant';


    // protected $fillable = [
    //    'tenant_id', 'parent_id','title','slug','content',
    // //    'meta_title',
    //     // 'meta_description','show_in_menu','order_no','status'
    // ];


    public function parent() {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Page::class, 'parent_id');
    }


}
