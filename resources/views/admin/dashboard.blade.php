{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard - PPP Department KPK')
@section('header-title', 'Dashboard Overview')

@section('content')
<div class="dashboard-container">
    {{-- Stats Cards - Dynamic grid based on sidebar state --}}
    <div id="dashboardCards" class="stats-grid grid gap-6 mb-8 transition-all duration-300">
        
        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-700 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-700"><i class="fas fa-project-diagram text-2xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Active Projects</p>
                    <h3 class="text-2xl font-bold">24</h3>
                    <a href="#" class="text-sm text-emerald-700 hover:underline mt-1 inline-block">View All</a>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600"><i class="fas fa-file-signature text-2xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Open Tenders</p>
                    <h3 class="text-2xl font-bold">8</h3>
                    <a href="#" class="text-sm text-blue-600 hover:underline mt-1 inline-block">View All</a>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600"><i class="fas fa-newspaper text-2xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">News Items</p>
                    <h3 class="text-2xl font-bold">15</h3>
                    <a href="#" class="text-sm text-yellow-600 hover:underline mt-1 inline-block">View All</a>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600"><i class="fas fa-folder-open text-2xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Public Documents</p>
                    <h3 class="text-2xl font-bold">42</h3>
                    <a href="#" class="text-sm text-purple-600 hover:underline mt-1 inline-block">View All</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity Section --}}
    <section class="mb-8">
        <h2 class="text-xl font-bold text-emerald-900 mb-4">Recent Activity</h2>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b"><div class="flex items-center"><div class="p-2 rounded-full bg-gray-100 text-emerald-700 mr-3"><i class="fas fa-project-diagram text-xl"></i></div><div><p class="font-medium">New project added: "Chitral Road Infrastructure"</p><p class="text-sm text-gray-500">2 hours ago</p></div></div></div>
            <div class="p-4 border-b"><div class="flex items-center"><div class="p-2 rounded-full bg-gray-100 text-blue-600 mr-3"><i class="fas fa-file-signature text-xl"></i></div><div><p class="font-medium">Tender "PPP/TEN/2023/005" closed</p><p class="text-sm text-gray-500">1 day ago</p></div></div></div>
            <div class="p-4 border-b"><div class="flex items-center"><div class="p-2 rounded-full bg-gray-100 text-yellow-600 mr-3"><i class="fas fa-newspaper text-xl"></i></div><div><p class="font-medium">News update published: "New PPP Policy"</p><p class="text-sm text-gray-500">2 days ago</p></div></div></div>
            <div class="p-4"><div class="flex items-center"><div class="p-2 rounded-full bg-gray-100 text-purple-600 mr-3"><i class="fas fa-folder-open text-xl"></i></div><div><p class="font-medium">New document uploaded: "Annual Report 2023"</p><p class="text-sm text-gray-500">3 days ago</p></div></div></div>
        </div>
    </section>
</div>
@endsection