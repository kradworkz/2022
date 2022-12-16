<template>
<div class="col-md-3">
    <div class="py-4"><div class="card border shadow-none mb-2"><a class="text-body"><div class="p-2"><div class="d-flex"><div class="avatar-xs align-self-center ml-2 mr-3"><div class="avatar-title rounded bg-transparent text-success font-size-20"><i class="text-success bx bxs-dashboard h2 mt-1"></i></div></div> <div class="overflow-hidden mr-auto"><h5 class="font-size-13 text-truncate mb-1">Home</h5> <p class="text-muted font-size-12 text-truncate mb-0">Dost IX</p></div></div></div></a></div> <div class="card border shadow-none mb-2"><a class="text-body"><div class="p-2"><div class="d-flex"><div class="avatar-xs align-self-center ml-2 mr-3"><div class="avatar-title rounded bg-transparent text-warning font-size-20"><i class="text-info bx bxs-book-bookmark h2 mt-1"></i></div></div> <div class="overflow-hidden mr-auto"><h5 class="font-size-13 text-truncate mb-1">My Documents</h5> <p class="text-muted font-size-12 text-truncate mb-0 documentcount">1 pending documents</p></div></div></div></a></div> <div class="card border shadow-none mb-2"><a class="text-body"><div class="p-2"><div class="d-flex"><div class="avatar-xs align-self-center ml-2 mr-3"><div class="avatar-title rounded bg-transparent text-danger font-size-20"><i class="text-danger bx bx-trip h2 mt-1"></i></div></div> <div class="overflow-hidden mr-auto"><h5 class="font-size-13 text-truncate mb-1">My Travels</h5> <p class="text-muted font-size-12 text-truncate mb-0 travelcount">2 pending travels</p></div></div></div></a></div> <div class="card border shadow-none mb-2"><a class="text-body"><div class="p-2"><div class="d-flex"><div class="avatar-xs align-self-center ml-2 mr-3"><div class="avatar-title rounded bg-transparent text-warning font-size-20"><i class="text-warning bx bxs-notepad h2 mt-1"></i></div></div> <div class="overflow-hidden mr-auto"><h5 class="font-size-13 text-truncate mb-1">My Requests</h5> <p class="text-muted font-size-12 text-truncate mb-0 requestcount">0 requests</p></div></div></div></a></div></div>
    <div class="card jobs-categories">
        <div class="card-body">
            <div class="input-group input-group-sm">
                <select v-model="type" class="form-select form-select-sm">
                    <option value="Employee" selected="">Employee</option>
                    <option :value="list.name" v-for="(list,index) in $page.props.auth.data.roles" v-bind:key="index">{{list.name}}</option>
                </select>
                <label class="input-group-text">User type</label>
            </div>
            <br>
            
            <ul class="list-unstyled categories-list">
                <li class="border-bottom">
                    <Link href="/home" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-home font-size-16 text-primary me-2"></i> <span class="me-auto">Home</span> 
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Employee'">
                    <Link href="/dtr" class="text-body d-flex align-items-center">
                        <i class="bx bxs-timer font-size-16 text-primary me-2"></i> <span class="me-auto">Daily Time Record </span> 
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Employee'">
                    <Link href="/survey" class="text-body d-flex align-items-center">
                        <i class="bx bx-list-ul font-size-16 me-2 text-primary"></i> <span class="me-auto">Morale Survey</span>
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Employee'">
                    <Link href="/leave" class="text-body d-flex align-items-center">
                        <i class="bx bx-git-pull-request font-size-16 me-2 text-primary"></i> <span class="me-auto">Leaves</span>
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Employee'">
                    <Link href="/cto" class="text-body d-flex align-items-center">
                        <i class="bx bx-calendar-plus font-size-16 me-2 text-primary"></i> <span class="me-auto">Compensatory Time Off</span>
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Employee'">
                    <Link href="/travel" class="text-body d-flex align-items-center">
                        <i class="bx bx-map font-size-16 me-2 text-primary"></i> <span class="me-auto">Travel Order</span>
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Employee'">
                    <Link href="/travelorder" class="text-body d-flex align-items-center">
                        <i class="bx bx-car font-size-16 me-2 text-primary"></i> <span class="me-auto">Vehicle Registration</span>
                    </Link>
                </li>
                 <li class="border-bottom" v-if="type =='Hr Staff'">
                    <Link href="/dtr/staff" class="text-body d-flex align-items-center">
                        <i class="bx bxs-timer font-size-16 text-primary me-2"></i> <span class="me-auto">Daily Time Record (HR)</span> 
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Hr Staff'">
                    <Link href="/survey/staff" class="text-body d-flex align-items-center">
                        <i class="bx bx-list-ul font-size-16 me-2 text-primary"></i> <span class="me-auto">Morale Survey (HR)</span>
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Hr Staff' || type == 'Hr Head' || type == 'Regional Director'">
                    <Link href="/leave/staff" class="text-body d-flex align-items-center">
                        <i class="bx bx-git-pull-request font-size-16 me-2 text-primary"></i> <span class="me-auto">Leave (HR)</span> 
                        <span v-if="$page.props.leave > 0" class="badge bg-success rounded-pill ms-2">{{ $page.props.leave }}</span>
                    </Link>
                </li>
                <li class="border-bottom" v-if="type =='Hr Staff' || type == 'Hr Head' || type == 'Regional Director'">
                    <Link href="/cto/staff" class="text-body d-flex align-items-center">
                        <i class="bx bx-calendar-plus font-size-16 me-2 text-primary"></i> <span class="me-auto">Compensatory Time Off (HR)</span> 
                        <span v-if="$page.props.leave > 0" class="badge bg-success rounded-pill ms-2">{{ $page.props.leave }}</span>
                    </Link>
                </li>

                <!-- <li class="border-bottom">
                    <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-share-variant font-size-16 me-2"></i> <span class="me-auto">Shared</span> <i class="mdi mdi-circle-medium text-danger ms-2"></i>
                    </a>
                </li>
                <li class="border-bottom">
                    <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-star-outline text-muted font-size-16 me-2"></i> <span class="me-auto">Starred</span>
                    </a>
                </li>
                <li class="border-bottom">
                    <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-trash-can text-danger font-size-16 me-2"></i> <span class="me-auto">Trash</span>
                    </a>
                </li>
                <li class="border-bottom">
                    <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-cog text-muted font-size-16 me-2"></i> <span class="me-auto">Setting</span><span class="badge bg-success rounded-pill ms-2">01</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            type: 'Employee',
        }
    },
}
</script>