<!-- Sección de Imágenes Adicionales del Perfil -->
<div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] backdrop-blur-sm rounded-2xl p-4 sm:p-6 mb-6 shadow-lg">
    <div class="flex items-center justify-center mb-4">
        <h2 class="text-xl sm:text-2xl font-bold flex items-center text-center">
            <i class="fas fa-images text-[#FFD700] mr-3"></i>
            Mis Fotos Adicionales
        </h2>
    </div>

    <div class="flex flex-col items-center space-y-6
                lg:grid lg:grid-cols-5 lg:gap-6 lg:space-y-0
                max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $currentImages = collect($user->imagenesPerfil)->keyBy('orden');
            $defaultPlaceholder = 'https://placehold.co/600x600/0A0E2A/A7B3EB?text=Foto+';
        @endphp

        @for ($i = 0; $i < 5; $i++)
            @php
                $order = $i + 1;
                $image = $currentImages->get($order);
                $imageUrl = $image ? asset($image->url_imagen) : $defaultPlaceholder . $order;
                $hasImage = (bool) $image;
            @endphp
            <div class="relative w-full max-w-xs aspect-square rounded-xl overflow-hidden border-2 border-[#4A0E7B] flex items-center justify-center group lg:w-full"
                 data-order="{{ $order }}"
                 @if($hasImage) data-image-id="{{ $image->id_imagen }}" @endif>
                @if ($hasImage)
                    <img src="{{ $imageUrl }}" alt="Foto de perfil {{ $order }}" 
                         class="w-full h-full object-cover image-preview">
                    <button type="button" 
                            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-red-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200 delete-image-btn" 
                            data-image-id="{{ $image->id_imagen }}">
                        <i class="fas fa-trash-alt text-2xl"></i>
                    </button>
                @else
                    <input type="file" id="image-upload-{{ $order }}" 
                           class="hidden image-upload-input" accept="image/*" 
                           data-order="{{ $order }}">
                    <label for="image-upload-{{ $order }}" 
                           class="w-full h-full flex flex-col items-center justify-center cursor-pointer text-[#A7B3EB] hover:text-[#FFD700] transition-colors duration-200">
                        <i class="fas fa-plus-circle text-5xl mb-2"></i>
                        <span class="text-sm">Añadir Foto</span>
                    </label>
                @endif
            </div>
        @endfor
    </div>

    <div class="flex justify-center mt-8">
        <button id="save-all-images-btn" 
                class="bg-[#FFD700] hover:bg-[#E0C000] text-[#1A1F4D] font-bold py-3 px-8 rounded-full transition duration-300 shadow-lg">
            Guardar Cambios
        </button>
    </div>
</div>

{{-- Modal de Confirmación de Eliminación --}}
<div id="delete-image-modal" 
     class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden p-4">
    <div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] rounded-2xl shadow-xl border border-[#FFD700]/50 p-6 w-full max-w-sm text-center">
        <div class="flex justify-center mb-4">
            <i class="fas fa-exclamation-triangle text-red-400 text-5xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-3">Confirmar Eliminación</h3>
        <p class="text-[#A7B3EB] mb-6">¿Estás seguro de que quieres eliminar esta imagen de tu perfil?</p>
        <div class="flex justify-center space-x-4">
            <button id="cancel-delete-btn" 
                    class="bg-[#3A3F6D] hover:bg-[#4A4F7D] text-white font-bold py-2 px-5 rounded-full transition duration-300">
                Cancelar
            </button>
            <button id="confirm-delete-btn" 
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-full transition duration-300" 
                    data-image-id="">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('delete-image-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    const saveAllImagesBtn = document.getElementById('save-all-images-btn');
    
    const filesToUpload = {};
    const imagesToDelete = [];

    function handleImageInputChange(event, inputElement) {
        const file = event.target.files[0];
        const order = inputElement.dataset.order;
        const parentDiv = inputElement.closest('.group');
        let imgElement = parentDiv.querySelector('.image-preview');

        if (file) {
            filesToUpload[order] = file;
            
            const existingImageId = parentDiv.dataset.imageId;
            if (existingImageId && imagesToDelete.includes(existingImageId)) {
                imagesToDelete.splice(imagesToDelete.indexOf(existingImageId), 1);
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (imgElement) {
                    imgElement.src = e.target.result;
                } else {
                    parentDiv.innerHTML = '';
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.alt = `Foto de perfil ${order}`;
                    newImg.className = 'w-full h-full object-cover image-preview';
                    parentDiv.appendChild(newImg);

                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.className = 'absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-red-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200 delete-image-btn';
                    deleteButton.innerHTML = '<i class="fas fa-trash-alt text-3xl"></i>';
                    deleteButton.addEventListener('click', function() {
                        confirmDeleteBtn.dataset.imageId = parentDiv.dataset.imageId || '';
                        deleteModal.classList.remove('hidden');
                    });
                    parentDiv.appendChild(deleteButton);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function resetImageSlot(parentDiv, order) {
        parentDiv.innerHTML = `
            <input type="file" id="image-upload-${order}" class="hidden image-upload-input" accept="image/*" data-order="${order}">
            <label for="image-upload-${order}" class="w-full h-full flex flex-col items-center justify-center cursor-pointer text-[#A7B3EB] hover:text-[#FFD700] transition-colors duration-200">
                <i class="fas fa-plus-circle text-6xl mb-3"></i>
                <span class="text-lg">Añadir Foto</span>
            </label>
        `;
        
        const newFileInput = parentDiv.querySelector('.image-upload-input');
        if (newFileInput) {
            newFileInput.addEventListener('change', function(event) {
                handleImageInputChange(event, newFileInput);
            });
        }
    }

    // Event listeners para inputs de archivo
    document.querySelectorAll('.image-upload-input').forEach(input => {
        input.addEventListener('change', function(event) {
            handleImageInputChange(event, input);
        });
    });

    // Event listeners para botones de eliminar
    document.querySelectorAll('.delete-image-btn').forEach(button => {
        button.addEventListener('click', function() {
            confirmDeleteBtn.dataset.imageId = this.dataset.imageId;
            deleteModal.classList.remove('hidden');
        });
    });

    // Event listeners para el modal
    cancelDeleteBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));
    
    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) deleteModal.classList.add('hidden');
    });

    confirmDeleteBtn.addEventListener('click', function() {
        const imageId = this.dataset.imageId;
        if (!imageId) {
            deleteModal.classList.add('hidden');
            return;
        }

        if (!imagesToDelete.includes(imageId)) {
            imagesToDelete.push(imageId);
        }

        const imageContainer = document.querySelector(`.group[data-image-id="${imageId}"]`);
        if (imageContainer) {
            const order = imageContainer.dataset.order;
            if (filesToUpload[order]) delete filesToUpload[order];
            resetImageSlot(imageContainer, order);
            imageContainer.removeAttribute('data-image-id');
        }

        deleteModal.classList.add('hidden');
    });

    // Manejador para guardar cambios
    saveAllImagesBtn.addEventListener('click', async function() {
        saveAllImagesBtn.disabled = true;
        saveAllImagesBtn.textContent = 'Guardando...';

        let uploadPromises = [];
        let deletePromises = [];

        // Subidas
        for (const order in filesToUpload) {
            const formData = new FormData();
            formData.append('image', filesToUpload[order]);
            formData.append('order', order);
            formData.append('_token', '{{ csrf_token() }}');

            uploadPromises.push(
                fetch('{{ route('profile.images.upload') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.ok ? response.json() : Promise.reject('Error al subir imagen'))
                .catch(error => ({ success: false, order, error }))
            );
        }

        // Eliminaciones
        for (const imageId of imagesToDelete) {
            deletePromises.push(
                fetch(`/profile/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.ok ? response.json() : Promise.reject('Error al eliminar imagen'))
                .catch(error => ({ success: false, imageId, error }))
            );
        }

        await Promise.all([...uploadPromises, ...deletePromises]);
        window.location.reload();
    });
});
</script>