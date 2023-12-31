@extends('template.main', ['menu' => "home", "submenu" => "Eixos"])

@section('titulo') Desenvolvimento Web @endsection

@section('conteudo')

<div class="row mb-3">
    <div class="col">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach ($data as $item)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_{{$item->id}}" aria-expanded="false" aria-controls="flush-collapseOne">
                            <span class="text-success fs-5">{{ $item->nome }}</span>
                        </button>
                    </h2>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
