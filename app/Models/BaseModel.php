<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * يمكنك إضافة منطق مشترك لكل الموديلات هنا لاحقًا
     * مثل: توحيد تواريخ التحويل، أو Scopes عامة، إلخ.
     */
}
