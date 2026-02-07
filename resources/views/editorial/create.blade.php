@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Crear una nueva Editorial</h2>
</div>
<div class="row">
     
       <form action="{{ route('editoriales.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
           @csrf <!-- Protección contra ataques ya implementado en laravel  https://www.welivesecurity.com/la-es/2015/04/21/vulnerabilidad-cross-site-request-forgery-csrf/-->
           @if($errors->any())
               <div class="alert alert-danger">
                   <ul>
                       @foreach($errors->all() as $error)
                           <li>{{$error}}</li>
                       @endforeach
                   </ul>
               </div>
           @endif
           <div class="form-group">
               <label for="nombre">Nombre</label>
               <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" />
           </div>
           <div class="form-group">
               <label for="address">Domicilio</label>
               <textarea class="form-control" id="address" name="address">{{old('address')}}</textarea>
           </div>
           <div class="form-group">
               <label for="email">Correo</label>
               <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" >


           </div>
           <button type="submit" class="btn btn-success">Guardar Editorial</button>
       </form>
   </div>
</div>
@endsection
