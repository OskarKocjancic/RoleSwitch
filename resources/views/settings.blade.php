@extends('layout')
@section('header-title', 'RoleSwitch')
@section('title', 'Settings')
@section('content')

    <div class="container">

        <form action="{{ route('save-settings.post') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="apiKeySelect">Select your API key:</label>
                <select class="form-control mt-2 mb-2" id="apiKeySelect" name="api_key">
                    @foreach (Auth::user()->keys as $key)
                        <option value="{{ $key->id }}" {{ $key->id == Auth::user()->selected_key ? 'selected' : '' }}>
                            {{ $key->api_key }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="apiKeyInput">Add a new API key:</label>
                <input type="text" class="form-control mt-2 mb-2" id="apiKeyInput" name="new_api_key"
                    placeholder="Enter your API key">
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <label class="custom-control-label" for="ttsToggle">Enable Text-to-Speech</label>
                    <input type="checkbox" class="custom-control-input" id="ttsToggle" name="tts_enabled"
                        {{ Auth::user()->tts_enabled ? 'checked' : '' }}>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
