<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-[#1e293b] antialiased">

<div class="max-w-5xl mx-auto px-4 py-10">
    
    <!-- Header & Stats -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">My Tasks</h1>
            <p class="text-slate-500">Manage your daily workflow efficiently.</p>
        </div>
        <div class="flex gap-3">
            <div class="bg-white p-3 px-5 rounded-2xl shadow-sm border border-slate-200">
                <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider">Pending</span>
                <span class="text-xl font-bold text-orange-500">{{ $stats['pending'] }}</span>
            </div>
            <div class="bg-white p-3 px-5 rounded-2xl shadow-sm border border-slate-200">
                <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider">Completed</span>
                <span class="text-xl font-bold text-emerald-500">{{ $stats['completed'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Add Task Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6">
                <h2 class="text-lg font-bold mb-4">Create New Task</h2>
                <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" required placeholder="Task title..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Priority Level</label>
                        <select name="priority" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                            <option value="Low">Low Priority</option>
                            <option value="Medium" selected>Medium Priority</option>
                            <option value="High">High Priority</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Additional details..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-200 transition-all transform active:scale-95">
                        <i class="fa fa-circle-plus mr-2"></i> Save Task
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Task List & Filters -->
        <div class="lg:col-span-2">
            
            <!-- Filters & Search -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <form action="{{ route('tasks.index') }}" method="GET" class="flex-1 flex gap-2">
                    <div class="relative flex-1">
                        <i class="fa fa-search absolute left-4 top-3.5 text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                    </div>
                    <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-slate-200 outline-none bg-white cursor-pointer">
                        <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </form>
            </div>

            <!-- Tasks -->
            <div class="space-y-4">
                @forelse($tasks as $task)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 group hover:shadow-md transition-all">
                    <!-- Status Toggle -->
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="w-7 h-7 rounded-lg border-2 flex items-center justify-center transition-all
                            {{ $task->status == 'Completed' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-200 text-transparent hover:border-indigo-400' }}">
                            <i class="fa fa-check text-xs"></i>
                        </button>
                    </form>

                    <!-- Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-slate-800 {{ $task->status == 'Completed' ? 'line-through opacity-50' : '' }}">
                                {{ $task->title }}
                            </h3>
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-md
                                {{ $task->priority == 'High' ? 'bg-red-50 text-red-600' : ($task->priority == 'Medium' ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600') }}">
                                {{ $task->priority }}
                            </span>
                        </div>
                        @if($task->description)
                            <p class="text-sm text-slate-500 line-clamp-1">{{ $task->description }}</p>
                        @endif
                    </div>

                    <!-- Delete -->
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDelete(this)" class="w-9 h-9 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors">
                            <i class="fa fa-trash-can text-sm"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-slate-200">
                    <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fa fa-layer-group text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">No tasks found. Try a different search or add one!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Delete Task?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                button.parentElement.submit();
            }
        })
    }

    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
    @endif
</script>
</body>
</html>