<template>
    <b-modal v-model="showModal" @ok="create($event)" id="update" size="lg" ok-title="Update" title="Update DTR" centered>        
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
        <form class="row ">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="fw-bold input-group-text">AM IN</div>
                    <input type="time" v-model="form.am_in" :readonly="(user.am_in_at.time !=  undefined)" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="fw-bold input-group-text">AM OUT</div>
                    <input type="time" data-provide="timepicker" v-model="form.am_out" :readonly="(user.am_out_at.time != undefined)" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="input-group">
                    <div class="fw-bold input-group-text">PM IN</div>
                    <input type="time" v-model="form.pm_in" :readonly="(user.pm_in_at.time != undefined)" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="input-group">
                    <div class="fw-bold input-group-text">PM OUT</div>
                    <input type="time" v-model="form.pm_out" :readonly="(user.pm_out_at.time != undefined)" class="form-control">
                </div>
            </div>
            <div class="col-md-12"><hr/></div>
            <div class="col-md-12">
                <textarea id="textarea" v-model="form.remarks" required class="form-control" maxlength="225" rows="2" placeholder="Reason for update"></textarea>
            </div>
        </form>
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
                },
                form: {
                    remarks: ''
                },
                showModal: false
            }
        },
        methods : {
            set(user){
                this.user = user;
                this.form = {
                    am_in: (user.am_in_at.time != undefined) ? user.am_in_at.time : '',
                    am_out: (user.am_out_at.time != undefined) ? user.am_out_at.time : '',
                    pm_in: (user.pm_in_at.time != undefined) ? user.pm_in_at.time : '',
                    pm_out: (user.pm_out_at.time != undefined) ? user.pm_out_at.time : '',
                };
                this.showModal = true;
            },

            create(){
                this.form = this.$inertia.form({
                     id: this.user.id,
                    am_in: (this.user.am_in_at.time != undefined) ? 'good' : this.form.am_in,
                    am_out: (this.user.am_out_at.time != undefined) ? 'good' : this.form.am_out,
                    pm_in: (this.user.pm_in_at.time != undefined) ? 'good' : this.form.pm_in,
                    pm_out: (this.user.pm_out_at.time != undefined) ? 'good' : this.form.pm_out,
                    remarks: this.form.remarks,
                });

                this.form.put('/dtr/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    }
                });
            },

            hide(){
                (this.form.hasOwnProperty('reset') ) ? this.form.reset().clearErrors() : this.user = {};
                this.showModal = false;
            },
        }
    }
</script>
