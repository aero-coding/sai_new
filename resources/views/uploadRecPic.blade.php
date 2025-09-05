<form action="{{ route('reports.featured-image.upload', $report) }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="file" name="featured_image" accept="image/*" required>
  <button type="submit">Subir/Reemplazar imagen</button>
</form>

@if ($report->hasMedia('featured_image'))
  <div style="margin-top:12px">
    <img src="{{ $report->getFirstMediaUrl('featured_image', 'optimized') }}" alt="Featured" style="max-width:420px">
    <form action="{{ route('reports.featured-image.delete', $report) }}" method="POST" style="margin-top:8px">
      @csrf @method('DELETE')
      <button type="submit">Eliminar</button>
    </form>
  </div>
@endif