@extends('layout')
@section('header-title', 'RoleSwitch')
@section('title', 'Manage roles')
@section('content')

    <style>
        /*         body{
                                                            background-color: var(--bs-primary);
                                                        } */
        .role-card {
            background-color: var(--bs-secondary);
            border-radius: 0.25rem;
        }

        textarea {
            resize: none;
        }

        .card-container {
            height: 60vh;
        }

        .add-container {}
    </style>

    <div class="container-l m-1 card-container scroll-pane overflow-auto">
        @foreach (Auth::user()->prompts as $role)
            <div class="mb-1 p-1 role-card ">
                <form action="{{ route('edit-prompt.post') }}" method="post">
                    @csrf
                    <h5 class="display-8 text-white">
                        {{ $role->name }}
                    </h5>
                    <div class="input-group">
                        <textarea class="form-control mb-1" rows="2" name="description">{{ $role->prompt }}</textarea>
                        <button class="btn btn-warning mb-1">Save</button>
                    </div>
                    <input type="hidden" name="id" value="{{ $role->id }}">
                </form>


                <div class="d-flex flex-row-reverse">
                    <form action="{{ route('delete-prompt.post') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $role->id }}">
                        <button class="btn btn-danger mb-1">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="add-container container-fluid mt-1">
        <form action="{{ route('add-prompt.post') }}" method="post">
            @csrf

            <h5 class="display-8">
                Add role:
            </h5>
            <input type="text" class="form-control mb-1" id="roleName" name="name"
                placeholder="Write your role name here">
            <textarea class="form-control mb-1" rows="3" id="rolePrompt" name="prompt"
                placeholder="Write your role description here"></textarea>
            <div class="input justify-content-lg-start">
                <button class="btn btn-success" id="addPrompt">Add a role</button>
            </div>
        </form>

    </div>




    {{--     <script>
        document.querySelector("#addPrompt").addEventListener("click", function() {
            var prompt = document.querySelector("#rolePrompt").value;
            var name = document.querySelector("#roleName").value;
            console.log(prompt, name);
            fetch('/add-prompt', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    prompt: prompt,
                    name: name
                })
            })

        });
    </script> --}}
@endsection
