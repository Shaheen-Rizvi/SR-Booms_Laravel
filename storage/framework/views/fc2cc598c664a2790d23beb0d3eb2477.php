<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SR_Blooms | Floral Elegance</title>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-white text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-10">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo + Brand -->
            <div class="flex items-center space-x-3">
                <img src="/images/logo.png" alt="SR_Blooms Logo" class="h-10 w-10 object-contain">
                <a href="/" class="text-2xl font-bold text-pink-600">SR_Blooms</a>
            </div>

            <!-- Nav Links -->
            <div class="flex space-x-6">
                <a href="/admin/login" class="text-sm text-gray-700 hover:text-pink-500">Admin Login</a>
                <a href="/login" class="text-sm text-gray-700 hover:text-pink-500">User Login</a>
                <a href="/logout" class="text-sm text-gray-700 hover:text-pink-500">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Spacer Below Navbar -->
    <div class="h-24"></div> <!-- Adjust this value as needed -->

<section class="w-full h-[160px] overflow-hidden relative mb-12">
    <img src="/images/banner5.jpg" alt="Floral Banner" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
        <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-wide">
            Elegance in Every Bloom
        </h2>
    </div>
</section>




    <!-- Hero Section -->
    <section class="pb-10 text-center">
        <h1 class="text-5xl font-extrabold text-pink-600 mb-3">Welcome to SR_Blooms 🌸</h1>
        <p class="text-lg text-gray-600">Minimalist floral artistry, handcrafted with love.</p>
    </section>

    <!-- Product Cards -->
    <section class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
           
        </div>
    </section>

</body>


   
    <section class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Product 1 -->
            <div class="bg-pink-50 rounded-2xl shadow-md hover:shadow-lg transition p-4">
                <img src="/images/banner1.jpg" alt="Rose Bouquet" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-semibold text-pink-700">Rose Bouquet</h2>
                <p class="text-sm text-gray-600 mb-2">A classic mix of red and pink roses.</p>
                <p class="text-lg font-bold text-green-700">Rs. 2,500.00</p>
                <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-full hover:bg-pink-700 text-sm">Add to Cart</button>
            </div>

            <!-- Product 2 -->
            <div class="bg-pink-50 rounded-2xl shadow-md hover:shadow-lg transition p-4">
                <img src="/images/banner2.jpg" alt="Sunflower Bliss" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-semibold text-pink-700">Sunflower Bliss</h2>
                <p class="text-sm text-gray-600 mb-2">Brighten any day with this sunny bunch.</p>
                <p class="text-lg font-bold text-green-700">Rs. 1,800.00</p>
                <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-full hover:bg-pink-700 text-sm">Add to Cart</button>
            </div>

            <!-- Product 3 -->
            <div class="bg-pink-50 rounded-2xl shadow-md hover:shadow-lg transition p-4">
                <img src="/images/banner3.jpg" alt="Lily Luxe" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-semibold text-pink-700">Lily Luxe</h2>
                <p class="text-sm text-gray-600 mb-2">Elegant white lilies with a touch of green.</p>
                <p class="text-lg font-bold text-green-700">Rs. 2,200.00</p>
                <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-full hover:bg-pink-700 text-sm">Add to Cart</button>
            </div>

            <!-- Product 4 -->
            <div class="bg-pink-50 rounded-2xl shadow-md hover:shadow-lg transition p-4">
                <img src="/images/banner4.jpg" alt="Daisy Delight" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-semibold text-pink-700">Daisy Delight</h2>
                <p class="text-sm text-gray-600 mb-2">A charming bouquet of white and yellow daisies.</p>
                <p class="text-lg font-bold text-green-700">Rs. 1,500.00</p>
                <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-full hover:bg-pink-700 text-sm">Add to Cart</button>
            </div>
        </div>
    </section>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\SR_Blooms\resources\views/welcome.blade.php ENDPATH**/ ?>