@extends('layout')
@section('header-title', 'RoleSwitch')
@section('title', 'RoleSwitch - Talk to ChatGPT')
@section('content')


    <style>
        .card-body {
            height: 75vh;
        }

        .chat-bubble {}

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .message {
            border-radius: 1rem;
            padding: 0.75rem;
            max-width: 50%;

        }
    </style>

    <div class="container-fluid mt-3 ">

        <div class="card">
            <select class="form-control" id="role">
                @foreach (Auth::user()->prompts as $prompt)
                    <option value="{{ $prompt->id }}">{{ $prompt->name }}</option>
                @endforeach
            </select>
            <div class="card-body scroll-pane overflow-auto" id="chat-messages">
            </div>
            <div class="input-group">
                <input type="text" class="form-control" id="message-input" placeholder="Send a message...">
                <button type="button" class="btn btn-primary" id="send-button">Send</button>
            </div>
        </div>

    </div>



    <script>
        function appendConversation() {
            var chat = document.querySelector("#chat-messages");
            chat.innerHTML = "";
            conversation.forEach((item) => {
                const chatBubble = document.createElement('div');
                chatBubble.classList.add('chat-bubble', 'd-flex', 'align-items-center');

                if (item.role === 'assistant') {
                    chatBubble.classList.add('left', 'justify-content-start');
                    chatBubble.innerHTML =
                        `<p class="message bg-secondary text-white">${item.content}</p>`;
                } else {
                    chatBubble.classList.add('right', 'justify-content-end');
                    chatBubble.innerHTML =
                        `<p class="message bg-primary text-white">${item.content}</p>`;
                }

                chat.appendChild(chatBubble);

            });
        }

        function textToSpeech(text) {
            let utterance = new SpeechSynthesisUtterance();

            utterance.text = text;

            utterance.voice = speechSynthesis.getVoices()[0];

            speechSynthesis.speak(utterance);
        }


        function appendLoadingBubble() {
            var chat = document.querySelector("#chat-messages");

            const loadingBubble = document.createElement('div');
            loadingBubble.classList.add('chat-bubble', 'd-flex', 'align-items-center', 'left', 'justify-content-start');

            loadingBubble.innerHTML =
                `<p class="message bg-secondary text-white"><i class="loading-icon-class"></i>Loading...</p>`;

            chat.appendChild(loadingBubble);
        }

        var conversation = [];

        document.querySelector("#send-button").addEventListener("click", () => {
            console.log("Sending to ChatGPT");
            var message = document.querySelector("#message-input").value;
            document.querySelector("#message-input").value = "";
            var id = document.querySelector("#role").value;
            console.log(id, message);
            var chat = document.querySelector("#chat-messages");
            var log = document.querySelector("#chat-log");
            conversation.push({
                role: "user",
                content: message
            });

            appendConversation();
            appendLoadingBubble();
            fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        conversation: conversation,
                        message: message,
                        id: id,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data['content']);
                    conversation.push({
                        role: 'assistant',
                        content: data['content']
                    });
                    appendConversation();
                    if (data['tts'] == 1)
                        textToSpeech(data['content']);

                });
        });

        document.querySelector("#role").addEventListener("change", () => {
            conversation = [];
            document.querySelector("#chat-messages").innerHTML = "";
        });
    </script>
@endsection
