@extends('dashboard.layouts.dashboard')
@section('title', 'Create Product')
@section('content')
    <style>
        .upload-card {
            background: #fff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
        }

        .drop-zone {
            border: 2px dashed #ced4da;
            border-radius: 14px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: .3s;
        }

        .drop-zone.dragover {
            background: #f4f6ff;
            border-color: #667eea;
        }

        .drop-zone i {
            font-size: 48px;
            color: #667eea;
        }

        .file-name {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
    </style>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="float-right m-3 flex">
                    <a class="px-4 py-2 bg-green-500 text-white rounded-lg mb-1" href="{{ route('admin.products.index') }}" wire:navigate ><i
                            class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">

                    <livewire:create-product />
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById("uploadForm");
        const dropZone = document.getElementById("dropZone");
        const fileInput = dropZone.querySelector("input[type=file]");
        const fileName = document.getElementById("fileName");

        // Click opens file picker
        dropZone.addEventListener("click", () => fileInput.click());

        // Show filename
        fileInput.addEventListener("change", () => {
            fileName.textContent = fileInput.files[0]?.name || "";
        });

        // Drag events
        ["dragenter", "dragover"].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                dropZone.classList.add("dragover");
            });
        });

        ["dragleave", "drop"].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                dropZone.classList.remove("dragover");
            });
        });
        // Drop file
        dropZone.addEventListener("drop", e => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            fileName.textContent = e.dataTransfer.files[0].name;
        });
    </script>
@endsection
