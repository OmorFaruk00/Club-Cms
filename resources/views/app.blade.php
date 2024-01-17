@extends('layouts.master')

@section('title', 'home')

@section('content')
<style>
    .head-title {
  background: #337ab7;
}

.head-title h2 {
  color: #fff;
  font-size: 25px;
  padding: 1% 5%;
  margin-left: 50px;
}

.main-content {
  padding: 5%;
}

.app {
  display: flex;
  justify-content: center;
}

.app-icon {
  height: 150px;
  width: 160px;
  border-radius: 20px;
  display: grid;
  place-items: center;
  transition: all 0.2s ease-in-out;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

.app-icon:hover {
  transform: scale(1.1);
  cursor: pointer;
}

.app-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
}

.app-title {
  font-size: 20px;
  text-align: center;
  margin-top: 20px;
}

.app-link {
  color: #000;
  text-decoration: none
}
</style>
<x-top-nav></x-top-nav>
<div class="bg">
    

    <div class="row main-content">
      <div class="col-md-3 col-xl-2 col-sm-6">
        <a class="app-link" >
          <div class="app">
            <div class="app-icon">
              <img src="image/cdc.png" alt="" />
            </div>
          </div>
          <p class="app-title">CDC</p>
        </a>
      </div>
      <div class="col-md-3 col-xl-2 col-sm-6">
        <a class="app-link" >
          <div class="app">
            <div class="app-icon">
              <img src="image/rrc.png" alt="" />
            </div>
          </div>
          <p class="app-title">RRC</p>
        </a>
      </div>
      <div class="col-md-3 col-xl-2 col-sm-6">
        <a class="app-link" >
          <div class="app">
            <div class="app-icon">
              <img src="image/rrc.png" alt="" />
            </div>
          </div>
          <p class="app-title">YEC</p>
        </a>
      </div>
      
      

     
      
    </div>
  </div>

@endsection