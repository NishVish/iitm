<div class="max-w-7xl mx-auto p-6 space-y-8 bg-slate-50 min-h-screen text-slate-800">

    <!-- Top Navigation / Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Super Admin Dashboard</h1>
            <p class="text-sm text-slate-500">Manage companies, system users, event configurations, and bookings.</p>
        </div>
        
        <!-- Search Company Input -->
        <div class="w-full md:w-80">
            <div class="relative">
                <input type="text" placeholder="Search company..." class="w-full pl-3 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50">
            </div>
        </div>
    </div>

    <!-- Quick Management Actions -->
    <div>
        <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-400 mb-3">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <a href="#" class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-indigo-500 transition-all flex justify-between items-center group">
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600">Edit Users</h3>
                    <p class="text-xs text-slate-500">Manage accounts & roles</p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 rounded text-slate-600 group-hover:bg-indigo-50 group-hover:text-indigo-600">Manage →</span>
            </a>

            <a href="#" class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-indigo-500 transition-all flex justify-between items-center group">
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600">Edit Events</h3>
                    <p class="text-xs text-slate-500">Update venues & pricing</p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 rounded text-slate-600 group-hover:bg-indigo-50 group-hover:text-indigo-600">Manage →</span>
            </a>

            <a href="#" class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-indigo-500 transition-all flex justify-between items-center group">
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600">Bookings by Event</h3>
                    <p class="text-xs text-slate-500">Track allocations & sales</p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 rounded text-slate-600 group-hover:bg-indigo-50 group-hover:text-indigo-600">View →</span>
            </a>

        </div>
    </div>

    <!-- Main Content Area: Tables Split -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- List of Events Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 bg-slate-900 text-white flex justify-between items-center">
                <h3 class="font-bold text-sm uppercase tracking-wider">List of Events</h3>
                <a href="#" class="text-xs text-indigo-300 hover:underline">Add New</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-600 border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Event Name</th>
                            <th class="p-3">Stall Rate</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono text-slate-500">6</td>
                            <td class="p-3 font-semibold text-slate-800">IITM Bengaluru (2026)</td>
                            <td class="p-3">₹37,000</td>
                            <td class="p-3 text-right">
                                <a href="#" class="text-indigo-600 font-semibold hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono text-slate-500">9</td>
                            <td class="p-3 font-semibold text-slate-800">IITM KOCHI (2026)</td>
                            <td class="p-3">₹34,000</td>
                            <td class="p-3 text-right">
                                <a href="#" class="text-indigo-600 font-semibold hover:underline">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- List of Users Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 bg-slate-900 text-white flex justify-between items-center">
                <h3 class="font-bold text-sm uppercase tracking-wider">List of Users</h3>
                <a href="#" class="text-xs text-indigo-300 hover:underline">Add User</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-600 border-b border-slate-200">
                        <tr>
                            <th class="p-3">User</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50">
                            <td class="p-3">
                                <p class="font-semibold text-slate-800">Moses</p>
                                <p class="text-[10px] text-slate-400">moses@example.com</p>
                            </td>
                            <td class="p-3">Sales Agent</td>
                            <td class="p-3"><span class="px-2 py-0.5 text-[10px] bg-emerald-100 text-emerald-800 font-semibold rounded-full">Active</span></td>
                            <td class="p-3 text-right">
                                <a href="#" class="text-indigo-600 font-semibold hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50">
                            <td class="p-3">
                                <p class="font-semibold text-slate-800">Deepak Kanabar</p>
                                <p class="text-[10px] text-slate-400">dk@example.com</p>
                            </td>
                            <td class="p-3">Exhibitor Admin</td>
                            <td class="p-3"><span class="px-2 py-0.5 text-[10px] bg-emerald-100 text-emerald-800 font-semibold rounded-full">Active</span></td>
                            <td class="p-3 text-right">
                                <a href="#" class="text-indigo-600 font-semibold hover:underline">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Bookings by Event Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Bookings by Event</h3>
                <p class="text-xs text-slate-500">Overview of confirmed company bookings grouped by active event.</p>
            </div>
            <select class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 bg-slate-50 focus:outline-none">
                <option>Filter by All Events</option>
                <option>IITM Bengaluru (2026)</option>
                <option>IITM KOCHI (2026)</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-semibold uppercase">
                        <th class="py-2">Booking Ref</th>
                        <th class="py-2">Company</th>
                        <th class="py-2">Event</th>
                        <th class="py-2">Stall Allocation</th>
                        <th class="py-2 text-right">Total Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 font-mono font-bold text-indigo-600">BKEFLHFVVLVQ</td>
                        <td class="py-3 font-medium text-slate-900">Growing Sphere Pvt. Ltd</td>
                        <td class="py-3">IITM Bengaluru</td>
                        <td class="py-3">Stall No: 5345 (4543 sq.ft)</td>
                        <td class="py-3 text-right font-bold text-emerald-600">Confirmed</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 font-mono font-bold text-indigo-600">BKEFLHFVVLVQ</td>
                        <td class="py-3 font-medium text-slate-900">Growing Sphere Pvt. Ltd</td>
                        <td class="py-3">IITM KOCHI</td>
                        <td class="py-3">Stall No: asdf (4 sq.ft)</td>
                        <td class="py-3 text-right font-bold text-emerald-600">Confirmed</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>