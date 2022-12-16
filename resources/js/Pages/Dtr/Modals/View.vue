<template>
    <b-modal v-model="showModal" @ok="create($event)" id="update" size="lg" ok-title="Update" title="View DTR" centered>        
        <div class="row mb-n2">
            <div class="col-sm-6">
                <div>
                    <p class="text-muted mb-0">Employee</p>
                    <h5 class="text-success">{{user.name}}</h5>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end mt-4 mt-sm-0">
                    <p class="text-muted mb-0">Date</p>
                    <h5 class="text-success">{{user.date}}</h5>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row text-center">
            <div class="col-lg-3">
                <div class="mt-2">
                    <p class="text-muted mb-1">Time In (am)</p>
                    <h5>{{ user.am_in }} <span v-if="user.am_in_at.is_updated" class="text-warning font-size-11">(updated)</span></h5>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mt-2">
                    <p class="text-muted mb-1">Time Out (am)</p>
                    <h5>{{ user.am_out }} <span v-if="user.am_out_at.is_updated" class="text-warning font-size-11">(updated)</span></h5>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mt-2">
                    <p class="text-muted mb-1">Time In (pm)</p>
                    <h5>{{ user.pm_in }} <span v-if="user.pm_in_at.is_updated" class="text-warning font-size-11">(updated)</span></h5>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mt-2">
                    <p class="text-muted mb-1">Time Out (pm)</p>
                    <h5>{{ user.pm_out }} <span v-if="user.pm_out_at.is_updated" class="text-warning font-size-11">(updated)</span></h5>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row mb-n2" v-if="Object.keys(user.remarks).length > 0">
            <div class="col-sm-6">
                <div>
                    <p class="font-size-10 text-muted mb-0">Remarks</p>
                    <h5 class="font-size-11 text-info">{{ user.remarks.remarks }}</h5>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end mt-4 mt-sm-0">
                    <p class="font-size-10 text-muted mb-0">Updated By</p>
                    <h5 class="font-size-11 text-danger">{{ user.remarks.updated_by.username }}</h5>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                user: {
                    am_in_at: {},
                    am_out_at: {},
                    pm_in_at: {},
                    pm_out_at: {},
                    remarks: { remarks: {}, updated_by: {}}
                },
                showModal: false
            }
        },

        methods : {
            set(user){
                this.user = user;
                console.log(this.user);
                this.showModal = true;
            }
        }
    }
</script>
