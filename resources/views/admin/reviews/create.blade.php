<x-admin-layout title="Add Customer Review">
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <div>
      <h5>Add Customer Review</h5>
      <p class="text-sm text-slate-500">Create testimonials that power the homepage slider.</p>
    </div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
      <li class="breadcrumb-item"><a href="#">Create</a></li>
    </ol>
  </div>

  <form action="{{ route('admin.reviews.store') }}" method="POST" class="space-y-6">
    @csrf

    @include('admin.reviews._form', ['review' => $review, 'products' => $products, 'customers' => $customers])

    <div class="flex flex-col justify-end gap-3 sm:flex-row">
      <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
        <i data-feather="x" class="h-4 w-4"></i>
        <span>Cancel</span>
      </a>
      <button type="submit" class="btn btn-primary">
        <i data-feather="save" class="h-4 w-4"></i>
        <span>Save Review</span>
      </button>
    </div>
  </form>
</x-admin-layout>
