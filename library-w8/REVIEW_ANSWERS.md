# Week 8 Review Answers

## Quiz 7: Form Handling and Validation

1. **What does `@csrf` insert, and which middleware checks it?**

   `@csrf` renders a hidden `_token` input containing the session's CSRF token. Laravel's CSRF validation middleware checks it on state-changing requests. A missing or mismatched token is rejected, typically with HTTP 419.

2. **Explain `old('title', $book->title)`: which value wins, and when?**

   Flashed old input wins after a validation redirect, so the user's attempted value is redisplayed. If there is no flashed value (for example, on the first edit page load), the expression falls back to the saved model title.

3. **Why redirect after a successful POST?**

   This is Post–Redirect–Get. The browser follows the redirect with a GET, so refreshing the result page does not resubmit the POST and create a duplicate record. The redirect can also carry a one-time flash message.

4. **What does `$request->validate()` do on failure and success?**

   On failure in a normal web request, Laravel redirects back with validation errors and flashed old input. For a JSON request it returns a 422 response. On success it returns only the validated fields, which should be the data passed to the model.

5. **What is the difference between `nullable`, `sometimes`, and `required_if`?**

   `nullable` permits a field to be present with a `null` value. `sometimes` runs that field's rules only when the field is present. `required_if:other,value` makes the field required when another field has the specified value.

6. **How do you make `unique` ignore the row being edited?**

   In the update request use `Rule::unique('books', 'isbn')->ignore($this->route('book'))`. This excludes the current book from the uniqueness check while still rejecting an ISBN used by another book. Pass the route-bound model or trusted key, never an arbitrary request value, to `ignore()`.

7. **In what order do `prepareForValidation()`, `authorize()`, and `rules()` run? What do `messages()` and `attributes()` change?**

   `prepareForValidation()` normalizes the incoming data first. Laravel then calls `authorize()`; if it returns false, the request stops with 403. If authorized, Laravel builds the validator using `rules()`. `messages()` supplies custom error text, while `attributes()` supplies friendly field labels in generated messages.

8. **Why must you never trust the client's filename?**

   The client controls that name. It can contain a misleading extension, collide with another file, or attempt path traversal/overwrite. Validate the uploaded content and let Laravel generate a random stored name with `store()`.

9. **Where does `store('covers', 'public')` write, and how is the file served?**

   It writes to `storage/app/public/covers` and returns a relative path such as `covers/random-name.jpg`. `php artisan storage:link` exposes that disk through `public/storage`; a Windows directory junction can serve the same purpose when symlink permissions are unavailable. A view can use `asset('storage/'.$path)`.

10. **What does `@method('DELETE')` actually send?**

    The HTML form still sends POST, with a hidden `_method=DELETE` field. Laravel's method-override handling treats the request as DELETE so it can match the resource delete route. `@csrf` is still required.

## Other Form Questions

- **Why not rely on the HTML `required` attribute?** Browser validation is only a convenience and can be bypassed. Server-side Form Request validation protects the application regardless of how the request was sent.
- **Why use `@method('PUT')` on an edit form?** HTML forms natively submit GET or POST only. Laravel reads the hidden `_method=PUT` field and routes the request as PUT.
- **What happens if `@csrf` is removed?** A normal browser POST without a valid session token is rejected with 419 Page Expired.
- **What happens if a field has no validation rule?** It is not included in `$request->validated()`, so it will not be mass-assigned from that validated array.
- **Why use a hidden `0` before a checkbox?** An unchecked checkbox is omitted from the request. The hidden value ensures the server receives `0`; the checked value `1` follows it and takes precedence.

## Page 34: Timed Product/Category Practice

The guide does not specify exact product columns, so this is one valid example using `name`, `sku`, `price`, and `stock`.

### Migration

```php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->timestamps();
});

Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->restrictOnDelete();
    $table->string('sku', 40)->unique();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->unsignedInteger('stock')->default(0);
    $table->timestamps();
});
```

### Product model

```php
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

protected $fillable = ['category_id', 'sku', 'name', 'price', 'stock'];

public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}

public function scopeSearch(Builder $query, ?string $search): void
{
    $query->when($search, function (Builder $query, string $search): void {
        $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('sku', 'like', '%'.$search.'%');
    });
}
```

### Factory

```php
return [
    'category_id' => Category::factory(),
    'sku' => fake()->unique()->bothify('SKU-####??'),
    'name' => fake()->words(3, true),
    'price' => fake()->randomFloat(2, 1, 500),
    'stock' => fake()->numberBetween(0, 100),
];
```

### Store Form Request

```php
public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'category_id' => ['required', 'integer', 'exists:categories,id'],
        'sku' => ['required', 'string', 'max:40', 'unique:products,sku'],
        'name' => ['required', 'string', 'max:255'],
        'price' => ['required', 'numeric', 'gt:0'],
        'stock' => ['required', 'integer', 'min:0'],
    ];
}

protected function prepareForValidation(): void
{
    $this->merge(['sku' => strtoupper(trim((string) $this->input('sku', '')))]);
}
```

### Store method

```php
public function store(StoreProductRequest $request): RedirectResponse
{
    $product = Product::create($request->validated());

    return redirect()->route('products.show', $product)
        ->with('status', 'Product created.');
}
```

The `Product::create()` call is the only write here; validation stays in the Form Request, and the redirect implements Post–Redirect–Get.

### N+1 question

A naive index that loads products, then reads `$product->category->name` inside a loop, runs one product query plus one category query per product: `1 + N`. Use `Product::with('category')->paginate(15)` (and apply filters before `paginate`) to eager-load categories in a bounded query set. Use `withCount('orders')` instead of querying a relation count for each row when the page needs a count.

## Midterm Checklist Answers

- **Week 6:** Put foreign keys and nullability/default modifiers in migrations. Model one-to-many with `hasMany` / `belongsTo`; many-to-many with `belongsToMany` on both sides and a correctly named pivot table. Use factories and seed related pivot data with `attach()`. `$fillable` is the allowlist of attributes that may be mass-assigned.
- **Week 7:** N+1 is one initial query followed by one related query per result; eager-load with `with()` or aggregate with `withCount()`. Conditional filters belong in scopes or `when()`. `Attribute::make` defines accessors/mutators. Model events include creating/created, updating/updated, saving/saved, and deleting/deleted; an observer can cancel a pre-event by returning false. Use `paginate()` and `withQueryString()` to retain filters.
- **Week 8:** A valid form includes CSRF, `old()` values, field and summary errors, and method spoofing for PUT/DELETE. Form Requests hold authorization and validation; update uniqueness ignores the current record. Store uploads with validated file content and a generated filename, then use Post–Redirect–Get.

## Page 37: Reflection

**Which validation belongs in a Form Request, and which belongs in a model or service?** Form Requests handle HTTP input shape, normalization, authorization, and field rules such as required values, formats, ranges, foreign keys, and file limits. Business rules depending on current system state belong in a service/domain workflow and should be rechecked transactionally. Database constraints provide the final protection for uniqueness and foreign keys.

**Three ways an unsafe upload could be abused:** A disguised executable or active-content file could be served as an image; oversized files could exhaust storage or processing resources; and a client-controlled filename could enable path traversal, collisions, or overwrites.