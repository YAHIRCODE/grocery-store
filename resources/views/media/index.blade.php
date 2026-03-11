@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Gestión Multimedia</h1>
        <p class="text-muted mb-0 small">Administra las imágenes del carrusel y videos principales.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-upload me-2"></i>Subir Nuevo Archivo</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tipo de Archivo</label>
                            <select name="file_type" id="file_type" class="form-select border-0 bg-light" required>
                                <option value="image">Imagen (JPG, PNG, WebP)</option>
                                <option value="video">Video (MP4, WebM)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Sección de Destino</label>
                            <select name="section" class="form-select border-0 bg-light" required>
                                <option value="carousel">Carrusel Principal</option>
                                <option value="hero_video">Video de Fondo (Hero)</option>
                                <option value="banner">Banner Promocional</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Seleccionar Archivo</label>
                            <div class="p-3 border-dashed rounded text-center bg-light" id="drop-area">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <input type="file" name="file" class="form-control form-control-sm" required>
                                <small class="text-muted d-block mt-2">Máximo 50MB</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Subir Multimedia
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                    <ul class="nav nav-pills small fw-bold" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-1" id="images-tab" data-bs-toggle="pill" data-bs-target="#images" type="button" role="tab">
                                <i class="fas fa-images me-1"></i> Carrusel ({{ $carouselImages->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-1" id="videos-tab" data-bs-toggle="pill" data-bs-target="#videos" type="button" role="tab">
                                <i class="fas fa-video me-1"></i> Videos ({{ $heroVideos->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="images" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small">
                                        <tr>
                                            <th class="ps-4">PREVIA</th>
                                            <th>RUTA</th>
                                            <th>FECHA</th>
                                            <th class="text-end pe-4">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($carouselImages as $image)
                                        <tr>
                                            <td class="ps-4">
                                                <img src="{{ $image->file_path }}" class="rounded shadow-sm" style="width: 80px; height: 45px; object-fit: cover;">
                                            </td>
                                            <td class="small text-muted">{{ basename($image->file_path) }}</td>
                                            <td class="small">{{ $image->created_at->format('d/m/Y') }}</td>
                                            <td class="text-end pe-4">
                                                <form action="{{ route('media.destroy', $image->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-white text-danger shadow-sm" onclick="return confirm('¿Eliminar esta imagen?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-5 text-muted small">No hay imágenes en el carrusel.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="videos" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small">
                                        <tr>
                                            <th class="ps-4">VIDEO</th>
                                            <th>RUTA</th>
                                            <th>ESTADO</th>
                                            <th class="text-end pe-4">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($heroVideos as $video)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="bg-dark rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 45px;">
                                                    <i class="fas fa-play text-white fa-xs"></i>
                                                </div>
                                            </td>
                                            <td class="small text-muted">{{ basename($video->file_path) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $video->is_active ? 'success' : 'secondary' }} small">
                                                    {{ $video->is_active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <form action="{{ route('media.destroy', $video->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-white text-danger shadow-sm" onclick="return confirm('¿Eliminar este video?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-5 text-muted small">No hay videos registrados.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed {
        border: 2px dashed #ced4da;
        transition: all 0.3s ease;
    }
    .btn-white {
        background: #fff;
        border: 1px solid #eee;
    }
    .nav-pills .nav-link.active {
        background-color: #4e73df;
    }
    .nav-pills .nav-link {
        color: #858796;
    }
</style>
@endsection