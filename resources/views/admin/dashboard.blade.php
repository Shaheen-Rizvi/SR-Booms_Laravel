@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Flower Dashboard</h1>
        <button onclick="document.getElementById('flowerModal').classList.remove('hidden')" class="bg-green-500 text-white px-4 py-2 rounded">Add New Flower</button>
    </div>

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-2 px-4 text-left">Name</th>
                <th class="py-2 px-4 text-left">Description</th>
                <th class="py-2 px-4 text-left">Price</th>
                <th class="py-2 px-4 text-left">Category</th>
                <th class="py-2 px-4 text-left">Status</th>
                <th class="py-2 px-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody id="flowers-container">
            <tr><td colspan="6" class="text-center p-4">Loading flowers...</td></tr>
        </tbody>
    </table>
</div>

{{-- Modal --}}
<div id="flowerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Add New Flower</h2>
        <form id="flower-form" onsubmit="event.preventDefault(); addFlower();">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" id="name" name="name" class="w-full mt-1 border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea id="description" name="description" class="w-full mt-1 border px-3 py-2 rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="w-full mt-1 border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium">Category</label>
                <select id="category_id" name="category_id" class="w-full mt-1 border px-3 py-2 rounded" required>
                    <option value="">Select Category</option>
                </select>
            </div>
            <input type="hidden" id="author_id" name="author_id" value="{{ Auth::id() }}">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('flowerModal').classList.add('hidden')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const token = sessionStorage.getItem('token');
    const headers = { Authorization: `Bearer ${token}` };

    function fetchAndRenderFlowers() {
        axios.get('/api/flowers', { headers })
            .then(response => {
                const flowers = response.data;
                const flowersContainer = document.getElementById('flowers-container');
                flowersContainer.innerHTML = '';

                if (flowers.length === 0) {
                    flowersContainer.innerHTML = `<tr><td colspan="6" class="text-center p-4">No flowers found.</td></tr>`;
                    return;
                }

                flowers.forEach(flower => {
                    const tr = document.createElement('tr');
                    tr.className = 'border-t';

                    tr.innerHTML = `
                        <td class="py-2 px-4">${flower.name}</td>
                        <td class="py-2 px-4">${flower.description}</td>
                        <td class="py-2 px-4">${flower.price}</td>
                        <td class="py-2 px-4">${flower.category.name}</td>
                        <td class="py-2 px-4">${flower.status}</td>
                        <td class="py-2 px-4">
                            <button onclick="editFlower(${flower.id})" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Edit</button>
                            <button onclick="deleteFlower(${flower.id})" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Delete</button>
                        </td>
                    `;
                    flowersContainer.appendChild(tr);
                });
            })
            .catch(error => {
                const flowersContainer = document.getElementById('flowers-container');
                console.error('Error fetching flowers:', error);
                flowersContainer.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-red-600">Failed to load flowers. Please check your API token and connection.</td></tr>`;
            });
    }

    function fetchCategories() {
        axios.get('/api/categories', { headers })
            .then(response => {
                const categories = response.data;
                const categorySelect = document.getElementById('category_id');
                categorySelect.innerHTML = `<option value="">Select Category</option>`;
                categories.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
            });
    }

    function addFlower() {
        const name = document.getElementById('name').value.trim();
        const description = document.getElementById('description').value.trim();
        const price = document.getElementById('price').value;
        const category_id = document.getElementById('category_id').value;
        const author_id = document.getElementById('author_id').value;

        if (!name || !description || !price || !category_id) {
            alert('All fields are required.');
            return;
        }

        if (isNaN(price) || parseFloat(price) <= 0) {
            alert('Please enter a valid price greater than zero.');
            return;
        }

        axios.post('/api/flowers', {
            name, description, price, category_id, author_id
        }, { headers })
            .then(() => {
                fetchAndRenderFlowers();
                document.getElementById('flower-form').reset();
                document.getElementById('flowerModal').classList.add('hidden');
            })
            .catch(error => {
                console.error('Error adding flower:', error);
                alert('Error adding flower');
            });
    }

    function editFlower(id) {
        const newName = prompt('Enter new name for flower:');
        if (!newName) return;

        axios.put(`/api/flowers/${id}`, { name: newName }, { headers })
            .then(() => {
                fetchAndRenderFlowers();
            })
            .catch(error => {
                console.error('Error editing flower:', error);
                alert('Error updating flower');
            });
    }

    function deleteFlower(id) {
        if (!confirm('Are you sure you want to delete this flower?')) return;

        axios.delete(`/api/flowers/${id}`, { headers })
            .then(() => {
                fetchAndRenderFlowers();
            })
            .catch(error => {
                console.error('Error deleting flower:', error);
                alert('Error deleting flower');
            });
    }

    // Initialize
    fetchAndRenderFlowers();
    fetchCategories();
</script>
@endsection
