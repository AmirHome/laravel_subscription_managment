# Changelog: Product Features Implementation

## تاریخ: 2025-10-22

### تغییرات اعمال شده در Package

این تغییرات برای افزودن قابلیت مدیریت Features در صفحه ویرایش Product انجام شده است.

---

## 📋 فایل‌های تغییر یافته

### 1️⃣ **Models** (تغییراتی نیاز نبود - قبلاً وجود داشت)

#### `src/Models/SubscriptionProduct.php`
```php
public function features()
{
    $prefix = subscriptionTablePrefix();
    
    return $this->belongsToMany(
        SubscriptionFeature::class,
        "{$prefix}product_feature",
        "plan_id",
        "feature_id",
    )->withPivot('value', 'active')
      ->withTimestamps();
}
```
✅ **وضعیت**: از قبل موجود بود

#### `src/Models/SubscriptionFeature.php`
```php
public function products()
{
    $prefix = subscriptionTablePrefix();
    
    return $this->belongsToMany(
        SubscriptionProduct::class,
        "{$prefix}product_feature",
        "feature_id",
        "plan_id",
    )->withPivot('value', 'active')
      ->withTimestamps();
}
```
✅ **وضعیت**: از قبل موجود بود

---

### 2️⃣ **Controller**

#### `src/Http/Controllers/SubscriptionProductsController.php`

**تغییرات:**

1. **در متد `edit()`**:
```php
// قبل:
$subscriptionProduct->load('group');

// بعد:
$subscriptionProduct->load('group', 'features');
```

2. **در متد `show()`**:
```php
// قبل:
$subscriptionProduct->load('group');

// بعد:
$subscriptionProduct->load('group', 'features');
```

3. **متد جدید `updateProductFeatures()`**:
```php
public function updateProductFeatures(Request $request, SubscriptionProduct $subscriptionProduct)
{
    $features_data = [];
    
    if ($request->has('features')) {
        foreach ($request->input('features') as $feature_id => $feature_data) {
            $feature = \Amirhome\LaravelSubscriptionManagment\Models\SubscriptionFeature::find($feature_id);
            
            // ستون value از نوع double و NOT NULL است با default 0
            $value = 0;
            if ($feature && $feature->limited && !empty($feature_data['value'])) {
                $value = is_numeric($feature_data['value']) ? (float)$feature_data['value'] : 0;
            }
            
            $features_data[$feature_id] = [
                'value' => $value,
                'active' => isset($feature_data['active']) ? 1 : 0,
            ];
        }
    }

    $subscriptionProduct->features()->sync($features_data);

    return redirect()
        ->route('ajax.subscription-products.edit', $subscriptionProduct->id)
        ->with('message', 'Product features updated successfully');
}
```

---

### 3️⃣ **Routes**

#### `src/Http/Routes/web.php`

**تغییر:**
```php
Route::group(['as'=>'ajax.'],function () {
    Route::resource('subscription-groups', SubscriptionGroupsController::class);
    
    // 👇 مسیر جدید برای features
    Route::post('subscription-products/{subscription_product}/features', [SubscriptionProductsController::class, 'updateProductFeatures'])
        ->name('subscription-products.updateProductFeatures');
    
    Route::resource('subscription-products', SubscriptionProductsController::class);
    Route::resource('subscriptions', SubscriptionsController::class);
    Route::resource('subscription-features', SubscriptionFeaturesController::class);
});
```

**نام Route**: `ajax.subscription-products.updateProductFeatures`

---

### 4️⃣ **Views**

#### **جدید**: `resources/views/admin/products/relationships/productFeatures.blade.php`

**محتوا**:
- فرم با table برای نمایش تمام features
- گروه‌بندی بر اساس SubscriptionGroup
- برای features محدود: textbox برای وارد کردن value
- برای features نامحدود: نمایش `-`
- checkbox برای active/passive کردن

**ویژگی‌های کلیدی**:
```php
@php
    $all_features = \Amirhome\LaravelSubscriptionManagment\Models\SubscriptionFeature::with('group')->get()->groupBy('group.name');
    $attached_features = $subscriptionProduct->features->pluck('pivot', 'id');
@endphp

@if($feature->limited)
    <input type="text" name="features[{{ $feature->id }}][value]" ... />
@else
    <span class="text-muted">-</span>
@endif
```

#### **ویرایش شده**: `resources/views/admin/products/edit.blade.php`

**تبدیل به Tab Structure**:

```blade
<div class="card">
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#product_edit" ...>
                Edit Product
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#product_features" ...>
                Features
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active m-3" id="product_edit">
            <!-- فرم ویرایش محصول -->
        </div>

        <div class="tab-pane m-3" id="product_features">
            @includeIf('laravel_subscription_managment::admin.products.relationships.productFeatures')
        </div>
    </div>
</div>
```

---

## 🔑 نکات مهم

### 1. مدیریت Value
- ستون `value` در جدول `saas_product_feature` از نوع `double` است
- **NOT NULL** با مقدار پیش‌فرض `0`
- برای features نامحدود: `value = 0`
- برای features محدود: عدد وارد شده یا `0`

### 2. Validation در Controller
```php
$value = 0;
if ($feature && $feature->limited && !empty($feature_data['value'])) {
    $value = is_numeric($feature_data['value']) ? (float)$feature_data['value'] : 0;
}
```

### 3. Route Naming
- App: `admin.subscription-products.updateProductFeatures`
- Package: `ajax.subscription-products.updateProductFeatures`

---

## ✅ نتیجه نهایی

### قابلیت‌های اضافه شده:
1. ✅ نمایش تمام features در tab جداگانه
2. ✅ گروه‌بندی features بر اساس group
3. ✅ تفکیک UI برای limited/unlimited features
4. ✅ ذخیره‌سازی صحیح در pivot table
5. ✅ validation مناسب برای value

### فایل‌های Package به‌روز شده:
- `src/Http/Controllers/SubscriptionProductsController.php`
- `src/Http/Routes/web.php`
- `resources/views/admin/products/edit.blade.php`
- `resources/views/admin/products/relationships/productFeatures.blade.php` (جدید)

---

## 🔄 سازگاری با App

تمام تغییرات در package با تغییرات در `app/` سازگار است:
- مدل‌ها: هر دو از relation یکسان استفاده می‌کنند
- کنترلر: منطق validation یکسان
- view: استفاده از translation keys package

---

**تاریخ آخرین به‌روزرسانی**: 2025-10-22  
**نسخه**: 1.1.0 (Product Features Support)
