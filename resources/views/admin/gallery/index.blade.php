{{-- resources/views/admin/gallery/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gallery - PPP Department KPK')
@section('header-title', 'Gallery Management')

@section('content')
<div class="max-w-full mx-auto">
    {{-- Success Message --}}
    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 hidden items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <span></span>
    </div>

    {{-- Error Message --}}
    <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 hidden items-center" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span></span>
    </div>

    {{-- Action Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-images mr-2 text-emerald-600"></i>
                All Gallery Items
            </h2>
            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full" id="totalGallery">
                6 Total
            </span>
        </div>
        <a href="{{ route('admin.gallery.add') }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>
            Add Gallery Item
        </a>
    </div>

    {{-- Gallery Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="galleryGrid">
        {{-- Dummy data will be inserted here via JavaScript --}}
    </div>

    {{-- Pagination --}}
    <div class="mt-8 bg-white px-6 py-4 rounded-lg shadow-md">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600">
                Showing 
                <span class="font-medium" id="showingStart">1</span> 
                to 
                <span class="font-medium" id="showingEnd">6</span> 
                of 
                <span class="font-medium" id="totalRecords">6</span> 
                results
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-emerald-600 text-sm font-medium text-white">1</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Gallery Details Modal --}}
<div id="galleryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeGalleryModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden transform transition-all">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                    <i class="fas fa-images mr-2 text-emerald-600"></i>
                    Gallery Details
                </h3>
                <button type="button" onclick="closeGalleryModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-130px)]">
                <div id="modalContent"></div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
                <button type="button" onclick="closeGalleryModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100">
                    Close
                </button>
                <a href="#" id="modalEditBtn" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" onclick="closeDeleteModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Delete Gallery Item</h3>
                    <p class="mt-2 text-sm text-gray-500">Are you sure you want to delete this gallery item? This action cannot be undone.</p>
                    <p class="mt-2 text-sm font-medium text-gray-700" id="deleteItemTitle"></p>
                </div>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="button" onclick="deleteGalleryItem()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Dummy Gallery Data
    const dummyGallery = [
        {
            id: 1,
            title: "Swat Expressway Inauguration Ceremony",
            location: "Swat, Khyber Pakhtunkhwa",
            date: "2024-03-15",
            description: "The inauguration ceremony of the Swat Expressway Extension project was attended by government officials and local community leaders.",
            thumbnail: 0,
            images: [
                "https://images.pexels.com/photos/1117210/pexels-photo-1117210.jpeg",
                "https://images.pexels.com/photos/169647/pexels-photo-169647.jpeg",
                "https://images.pexels.com/photos/262367/pexels-photo-262367.jpeg"
            ],
            created_at: "2024-03-15 10:30:00"
        },
        {
            id: 2,
            title: "Healthcare City Groundbreaking",
            location: "Peshawar, Khyber Pakhtunkhwa",
            date: "2024-02-20",
            description: "Groundbreaking ceremony for the Peshawar Healthcare City project, a state-of-the-art medical complex spanning 500 acres.",
            thumbnail: 1,
            images: [
                "https://images.pexels.com/photos/263402/pexels-photo-263402.jpeg",
                "https://images.pexels.com/photos/127873/pexels-photo-127873.jpeg",
                "https://images.pexels.com/photos/416754/pexels-photo-416754.jpeg",
                "https://images.pexels.com/photos/236380/pexels-photo-236380.jpeg"
            ],
            created_at: "2024-02-20 14:15:00"
        },
        {
            id: 3,
            title: "Investor Conference 2024",
            location: "Islamabad",
            date: "2024-03-10",
            description: "Annual PPP Investor Conference bringing together government officials, private investors, and industry experts.",
            thumbnail: 0,
            images: [
                "https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg",
                "https://images.pexels.com/photos/3184339/pexels-photo-3184339.jpeg",
                "https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg"
            ],
            created_at: "2024-03-10 09:00:00"
        },
        {
            id: 4,
            title: "Chitral Hydropower Site Visit",
            location: "Chitral, Khyber Pakhtunkhwa",
            date: "2024-01-25",
            description: "Site visit to the Chitral Hydropower Project location with engineering teams and environmental experts.",
            thumbnail: 2,
            images: [
                "https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg",
                "https://images.pexels.com/photos/221012/pexels-photo-221012.jpeg",
                "https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg"
            ],
            created_at: "2024-01-25 11:30:00"
        },
        {
            id: 5,
            title: "D.I. Khan Smart City Completion",
            location: "Dera Ismail Khan, KPK",
            date: "2024-02-01",
            description: "Celebration ceremony marking the successful completion of the D.I. Khan Smart City project.",
            thumbnail: 0,
            images: [
                "https://images.pexels.com/photos/323705/pexels-photo-323705.jpeg",
                "https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg",
                "https://images.pexels.com/photos/258154/pexels-photo-258154.jpeg"
            ],
            created_at: "2024-02-01 16:00:00"
        },
        {
            id: 6,
            title: "Capacity Building Workshop",
            location: "Abbottabad, KPK",
            date: "2024-03-05",
            description: "Three-day capacity building workshop on PPP project management for government officials.",
            thumbnail: 1,
            images: [
                "https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg",
                "https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg",
                "https://images.pexels.com/photos/3184357/pexels-photo-3184357.jpeg"
            ],
            created_at: "2024-03-05 08:30:00"
        }
    ];

    let currentDeleteId = null;

    // Render gallery grid
    function renderGallery() {
        const grid = document.getElementById('galleryGrid');
        const totalSpan = document.getElementById('totalGallery');
        const showingStart = document.getElementById('showingStart');
        const showingEnd = document.getElementById('showingEnd');
        const totalRecords = document.getElementById('totalRecords');
        
        totalSpan.textContent = `${dummyGallery.length} Total`;
        showingStart.textContent = dummyGallery.length > 0 ? 1 : 0;
        showingEnd.textContent = dummyGallery.length;
        totalRecords.textContent = dummyGallery.length;
        
        if (dummyGallery.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-images text-5xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 text-lg mb-2">No gallery items found</p>
                            <p class="text-gray-400 text-sm mb-4">Get started by adding your first gallery item</p>
                            <a href="{{ route('admin.gallery.add') }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Add Gallery Item
                            </a>
                        </div>
                    </div>
                </div>
            `;
            return;
        }
        
        grid.innerHTML = dummyGallery.map(item => {
            const thumbnailImage = item.images[item.thumbnail] || item.images[0];
            const imageCount = item.images.length;
            const formattedDate = item.date ? new Date(item.date).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'}) : '';
            
            return `
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative h-48 overflow-hidden bg-gray-100">
                        <img src="${thumbnailImage}" 
                             alt="${item.title}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
                        <span class="absolute top-2 right-2 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                            <i class="fas fa-images mr-1"></i>${imageCount} ${imageCount === 1 ? 'image' : 'images'}
                        </span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900 mb-1 line-clamp-1">${item.title}</h4>
                        ${item.location ? `
                            <p class="text-sm text-gray-500 mb-2 flex items-center">
                                <i class="fas fa-map-marker-alt mr-1 text-emerald-500"></i>
                                ${item.location}
                            </p>
                        ` : ''}
                        ${formattedDate ? `
                            <p class="text-xs text-gray-400 mb-3 flex items-center">
                                <i class="far fa-calendar-alt mr-1"></i>
                                ${formattedDate}
                            </p>
                        ` : ''}
                        ${item.description ? `
                            <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                                ${item.description.length > 80 ? item.description.substring(0, 80) + '...' : item.description}
                            </p>
                        ` : ''}
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <button onclick="viewGalleryItem(${item.id})" 
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fas fa-eye mr-1"></i> View
                            </button>
                            <div class="flex items-center gap-2">
                                <a href="/admin/gallery/${item.id}/edit" 
                                   class="text-emerald-600 hover:text-emerald-800 p-1 rounded hover:bg-emerald-50"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete(${item.id})" 
                                        class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // View gallery item details
    window.viewGalleryItem = function(id) {
        const item = dummyGallery.find(g => g.id === id);
        if (!item) return;
        
        const modal = document.getElementById('galleryModal');
        const modalContent = document.getElementById('modalContent');
        const modalEditBtn = document.getElementById('modalEditBtn');
        
        modalEditBtn.href = `/admin/gallery/${id}/edit`;
        
        const formattedDate = item.date ? new Date(item.date).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'}) : 'N/A';
        const createdAt = new Date(item.created_at).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'});
        
        // Generate images grid
        const imagesHtml = item.images.map((img, index) => `
            <div class="relative group">
                <img src="${img}" 
                     alt="Gallery image ${index + 1}" 
                     class="w-full h-32 object-cover rounded-lg border border-gray-200"
                     onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
                ${index === item.thumbnail ? `
                    <span class="absolute top-1 left-1 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded">
                        <i class="fas fa-star mr-1"></i>Thumbnail
                    </span>
                ` : ''}
            </div>
        `).join('');
        
        modalContent.innerHTML = `
            <div class="space-y-6">
                <div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">${item.title}</h4>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        ${item.location ? `
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-1 text-emerald-500"></i>
                                ${item.location}
                            </span>
                        ` : ''}
                        ${formattedDate !== 'N/A' ? `
                            <span class="flex items-center">
                                <i class="far fa-calendar-alt mr-1"></i>
                                ${formattedDate}
                            </span>
                        ` : ''}
                        <span class="flex items-center">
                            <i class="far fa-clock mr-1"></i>
                            Added: ${createdAt}
                        </span>
                    </div>
                </div>
                
                ${item.description ? `
                    <div>
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Description</h5>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">${item.description}</p>
                        </div>
                    </div>
                ` : ''}
                
                <div>
                    <h5 class="text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-images mr-1"></i>
                        Gallery Images (${item.images.length})
                    </h5>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        ${imagesHtml}
                    </div>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeGalleryModal = function() {
        document.getElementById('galleryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    // Delete functions
    window.confirmDelete = function(id) {
        const item = dummyGallery.find(g => g.id === id);
        if (!item) return;
        
        currentDeleteId = id;
        document.getElementById('deleteItemTitle').textContent = item.title;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.deleteGalleryItem = function() {
        if (!currentDeleteId) return;
        
        const index = dummyGallery.findIndex(g => g.id === currentDeleteId);
        if (index > -1) {
            const itemTitle = dummyGallery[index].title;
            dummyGallery.splice(index, 1);
            
            renderGallery();
            
            const successMsg = document.getElementById('successMessage');
            successMsg.querySelector('span').textContent = `"${itemTitle}" deleted successfully!`;
            successMsg.classList.remove('hidden');
            setTimeout(() => successMsg.classList.add('hidden'), 3000);
        }
        
        closeDeleteModal();
        currentDeleteId = null;
    };

    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteId = null;
    };

    // Keyboard events
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGalleryModal();
            closeDeleteModal();
        }
    });

    document.addEventListener('click', function(event) {
        const galleryModal = document.getElementById('galleryModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === galleryModal) closeGalleryModal();
        if (event.target === deleteModal) closeDeleteModal();
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderGallery();
    });
</script>
@endpush