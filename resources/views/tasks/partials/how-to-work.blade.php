<!-- How To Work Modal -->
<x-base.dialog id="how-to-work-modal" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-gradient-to-r from-primary to-primary/70 text-white">
            <h2 class="text-lg font-semibold flex items-center gap-2">
                <x-base.lucide icon="book-open" class="w-5 h-5" />
                Task Management System - How To Work
            </h2>
            <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white transition-colors">
                <x-base.lucide icon="x" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>
        <x-base.dialog.description class="p-6 max-h-[70vh] overflow-y-auto">
            <div class="space-y-8">
                <!-- Introduction -->
                <div class="bg-gradient-to-r from-primary/5 to-primary/10 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-primary mb-3 flex items-center gap-2">
                        <x-base.lucide icon="info" class="w-6 h-6" />
                        Introduction
                    </h3>
                    <p class="text-slate-600 leading-relaxed">
                        The Task Management System is a comprehensive solution for managing tasks, tracking progress, 
                        and collaborating with team members. It supports multiple views (List & Kanban), task steps, 
                        comments, likes, time tracking, and extension requests.
                    </p>
                </div>

                <!-- Quick Start -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="rocket" class="w-5 h-5 text-primary" />
                        Quick Start Guide
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">1</span>
                                <h4 class="font-semibold">Create a Task</h4>
                            </div>
                            <p class="text-sm text-slate-600 ml-11">Click "Add Task" button to create a new task with title, description, priority, and due date.</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">2</span>
                                <h4 class="font-semibold">Assign to Employee</h4>
                            </div>
                            <p class="text-sm text-slate-600 ml-11">Select an employee to assign the task. They will receive a notification automatically.</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">3</span>
                                <h4 class="font-semibold">Add Task Steps</h4>
                            </div>
                            <p class="text-sm text-slate-600 ml-11">Break down the task into smaller steps for better tracking and progress monitoring.</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">4</span>
                                <h4 class="font-semibold">Track Progress</h4>
                            </div>
                            <p class="text-sm text-slate-600 ml-11">Monitor task progress through the Kanban board or list view. Update status as work progresses.</p>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="star" class="w-5 h-5 text-yellow-500" />
                        Key Features
                    </h3>
                    <div class="space-y-4">
                        <!-- Task Types -->
                        <div class="border border-slate-200 rounded-lg p-4">
                            <h4 class="font-semibold text-slate-800 mb-2 flex items-center gap-2">
                                <x-base.lucide icon="layers" class="w-4 h-4 text-primary" />
                                Task Types
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded">
                                    <x-base.lucide icon="check-square" class="w-4 h-4 text-slate-500" />
                                    <span>Task</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 bg-red-50 rounded">
                                    <x-base.lucide icon="bug" class="w-4 h-4 text-red-500" />
                                    <span>Bug</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 bg-purple-50 rounded">
                                    <x-base.lucide icon="sparkles" class="w-4 h-4 text-purple-500" />
                                    <span>Feature</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 bg-blue-50 rounded">
                                    <x-base.lucide icon="trending-up" class="w-4 h-4 text-blue-500" />
                                    <span>Improvement</span>
                                </div>
                            </div>
                        </div>

                        <!-- Priority Levels -->
                        <div class="border border-slate-200 rounded-lg p-4">
                            <h4 class="font-semibold text-slate-800 mb-2 flex items-center gap-2">
                                <x-base.lucide icon="flag" class="w-4 h-4 text-primary" />
                                Priority Levels
                            </h4>
                            <div class="flex flex-wrap gap-2 text-sm">
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-medium">High Priority</span>
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">Medium Priority</span>
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">Low Priority</span>
                            </div>
                        </div>

                        <!-- Status Flow -->
                        <div class="border border-slate-200 rounded-lg p-4">
                            <h4 class="font-semibold text-slate-800 mb-2 flex items-center gap-2">
                                <x-base.lucide icon="git-branch" class="w-4 h-4 text-primary" />
                                Task Status Flow
                            </h4>
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">Pending</span>
                                <x-base.lucide icon="arrow-right" class="w-4 h-4 text-slate-400" />
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">In Progress</span>
                                <x-base.lucide icon="arrow-right" class="w-4 h-4 text-slate-400" />
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">Completed</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Tasks can also be marked as "Cancelled" if needed.</p>
                        </div>
                    </div>
                </div>

                <!-- Views -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="layout" class="w-5 h-5 text-primary" />
                        Available Views
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <x-base.lucide icon="list" class="w-5 h-5 text-primary" />
                                <h4 class="font-semibold">List View</h4>
                            </div>
                            <p class="text-sm text-slate-600">Traditional table view with sorting, filtering, and pagination. Best for detailed task management and bulk operations.</p>
                        </div>
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <x-base.lucide icon="layout" class="w-5 h-5 text-primary" />
                                <h4 class="font-semibold">Kanban View</h4>
                            </div>
                            <p class="text-sm text-slate-600">Visual board with drag-and-drop functionality. Tasks are organized by status columns for easy workflow management.</p>
                        </div>
                    </div>
                </div>

                <!-- Task Steps -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="list-checks" class="w-5 h-5 text-primary" />
                        Task Steps (Timeline)
                    </h3>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="check" class="w-4 h-4 text-green-500 mt-0.5" />
                                <span>Break down complex tasks into smaller, manageable steps</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="check" class="w-4 h-4 text-green-500 mt-0.5" />
                                <span>Mark steps as completed to track progress</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="check" class="w-4 h-4 text-green-500 mt-0.5" />
                                <span>Delegate individual steps to different team members</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="check" class="w-4 h-4 text-green-500 mt-0.5" />
                                <span>Progress bar automatically updates based on completed steps</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="check" class="w-4 h-4 text-green-500 mt-0.5" />
                                <span>Task auto-completes when all steps are done</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Comments & Collaboration -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="message-circle" class="w-5 h-5 text-primary" />
                        Comments & Collaboration
                    </h3>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="message-square" class="w-4 h-4 text-blue-500 mt-0.5" />
                                <span>Add comments to discuss task details with team members</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="lock" class="w-4 h-4 text-yellow-500 mt-0.5" />
                                <span>Mark comments as "Internal" for private team discussions</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="thumbs-up" class="w-4 h-4 text-green-500 mt-0.5" />
                                <span>React to comments with likes/dislikes</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-base.lucide icon="heart" class="w-4 h-4 text-red-500 mt-0.5" />
                                <span>Like tasks to appreciate team members' work</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Extension Requests -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="clock" class="w-5 h-5 text-primary" />
                        Time Extension Requests
                    </h3>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <p class="text-sm text-amber-800 mb-3">
                            If you need more time to complete a task, you can request a deadline extension:
                        </p>
                        <ol class="space-y-2 text-sm text-amber-700">
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
                                <span>Open the task details page</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center text-xs font-bold flex-shrink-0">2</span>
                                <span>Click "Request Time Extension" button</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center text-xs font-bold flex-shrink-0">3</span>
                                <span>Select the new due date and provide a reason</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center text-xs font-bold flex-shrink-0">4</span>
                                <span>Wait for manager approval (you'll receive a notification)</span>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Notifications -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="bell" class="w-5 h-5 text-primary" />
                        Automatic Notifications
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="px-4 py-2 text-left font-semibold">Event</th>
                                    <th class="px-4 py-2 text-left font-semibold">Recipient</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                <tr>
                                    <td class="px-4 py-2">New task assigned</td>
                                    <td class="px-4 py-2">Assigned employee</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Task started</td>
                                    <td class="px-4 py-2">Task creator</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Task completed</td>
                                    <td class="px-4 py-2">Task creator</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">New comment added</td>
                                    <td class="px-4 py-2">Task creator & assignee</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Task liked</td>
                                    <td class="px-4 py-2">Assigned employee</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Extension requested</td>
                                    <td class="px-4 py-2">Managers & task creator</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Extension approved/rejected</td>
                                    <td class="px-4 py-2">Request submitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Keyboard Shortcuts -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="keyboard" class="w-5 h-5 text-primary" />
                        Tips & Best Practices
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-semibold text-green-800 mb-2">Do's ✓</h4>
                            <ul class="space-y-1 text-sm text-green-700">
                                <li>• Set realistic due dates</li>
                                <li>• Break large tasks into steps</li>
                                <li>• Update status regularly</li>
                                <li>• Add descriptive comments</li>
                                <li>• Request extensions early</li>
                            </ul>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">Don'ts ✗</h4>
                            <ul class="space-y-1 text-sm text-red-700">
                                <li>• Don't leave tasks without updates</li>
                                <li>• Don't ignore overdue tasks</li>
                                <li>• Don't skip adding descriptions</li>
                                <li>• Don't forget to complete steps</li>
                                <li>• Don't wait until deadline to request extension</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Additional Features -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <x-base.lucide icon="plus-circle" class="w-5 h-5 text-primary" />
                        Additional Features
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-slate-50 rounded-lg">
                            <x-base.lucide icon="paperclip" class="w-8 h-8 text-primary mx-auto mb-2" />
                            <h4 class="font-semibold text-sm">Attachments</h4>
                            <p class="text-xs text-slate-500">Upload files and documents</p>
                        </div>
                        <div class="text-center p-4 bg-slate-50 rounded-lg">
                            <x-base.lucide icon="git-branch" class="w-8 h-8 text-primary mx-auto mb-2" />
                            <h4 class="font-semibold text-sm">Subtasks</h4>
                            <p class="text-xs text-slate-500">Create nested subtasks</p>
                        </div>
                        <div class="text-center p-4 bg-slate-50 rounded-lg">
                            <x-base.lucide icon="timer" class="w-8 h-8 text-primary mx-auto mb-2" />
                            <h4 class="font-semibold text-sm">Time Tracking</h4>
                            <p class="text-xs text-slate-500">Log hours worked</p>
                        </div>
                        <div class="text-center p-4 bg-slate-50 rounded-lg">
                            <x-base.lucide icon="tag" class="w-8 h-8 text-primary mx-auto mb-2" />
                            <h4 class="font-semibold text-sm">Labels</h4>
                            <p class="text-xs text-slate-500">Organize with custom labels</p>
                        </div>
                        <div class="text-center p-4 bg-slate-50 rounded-lg">
                            <x-base.lucide icon="folder" class="w-8 h-8 text-primary mx-auto mb-2" />
                            <h4 class="font-semibold text-sm">Projects</h4>
                            <p class="text-xs text-slate-500">Group tasks by project</p>
                        </div>
                        <div class="text-center p-4 bg-slate-50 rounded-lg">
                            <x-base.lucide icon="activity" class="w-8 h-8 text-primary mx-auto mb-2" />
                            <h4 class="font-semibold text-sm">Activity Log</h4>
                            <p class="text-xs text-slate-500">Track all changes</p>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-gradient-to-r from-slate-100 to-slate-50 rounded-xl p-6 text-center">
                    <x-base.lucide icon="help-circle" class="w-12 h-12 text-primary mx-auto mb-3" />
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Need Help?</h3>
                    <p class="text-sm text-slate-600">
                        If you have any questions or need assistance, please contact your system administrator 
                        or refer to the complete documentation.
                    </p>
                </div>
            </div>
        </x-base.dialog.description>
        <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
            <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="check" class="w-4 h-4 mr-2" />
                Got it!
            </button>
        </x-base.dialog.footer>
    </x-base.dialog.panel>
</x-base.dialog>
