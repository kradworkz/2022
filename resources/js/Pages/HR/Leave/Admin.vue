<template>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center mt-n1 mb-n1">
                <ul class="list-unstyled hstack gap-3 mb-0 font-size-11 flex-grow-1">
                    <li class="fw-bold font-size-13">Leaves (HR)</li>
                </ul>
                <div class="hstack gap-2">
                    <ul class="list-inline user-chat-nav text-end dropdown" style="width: 230px; margin-top: -20px; margin-bottom: -20px;">
                        <Pagination @fetch="fetch" :links="links" :pagination="meta"/>
                    </ul>
                    <div class="input-group input-group-sm">
                        <select v-model="department" @change="fetch()" class="form-select form-select-sm" style="width: 100px;">
                            <option value="" selected>All Departments</option>
                            <option :value="department.id" v-for="(department,index) in departments" v-bind:key="index">{{department.others}}</option>
                        </select>
                        <label class="input-group-text">Department</label>
                        <select v-model="status" @change="fetch()" class="form-select form-select-sm" style="width: 100px;">
                            <option value="" selected>All Statuses</option>
                            <option :value="status.id" v-for="(status,index) in statuses" v-bind:key="index">{{status.name}}</option>
                        </select>
                        <label class="input-group-text">Status</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }">
            <div class="table-responsive" data-simplebar :style="{ height: (heightProfile-90) + 'px' }">
                <table class="table table-centered table-nowrap align-middle">
                    <thead class="thead-light">
                        <tr class="font-size-11">
                            <th style="width: 20%;" class="text-left">Name</th>
                            <th style="width: 20%;" class="text-center">Date</th>
                            <th style="width: 20%;" class="text-center">Type</th>
                            <th style="width: 15%;" class="text-center">Created At</th>
                            <th style="width: 20%;" class="text-center">Status</th>
                            <th style="width: 5%;" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="list in lists" v-bind:key="list.id">
                            <td class="text-left fw-bold">{{ list.profile.name }}</td>
                            <td class="text-center">{{ list.start }} to {{ list.end }}</td>
                            <td class="text-center">{{ list.type.name }}</td>
                            <td class="text-center">{{ list.created_at }}</td>
                            <td class="text-center">
                                <span :class="'badge bg-'+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-end">
                                <button @click="view(list)" type="button" class="btn btn-light btn-sm w-md waves-effect waves-light">View</button>
                                <!-- <a class="me-3 text-dark" @click="view(list)"><i class='bx bx-show' ></i></a> -->
                                <button v-if="list.status.name == 'Approved'" @click="print(list)" type="button" class="btn btn-primary btn-sm ms-1 waves-effect waves-light"><i class='bx bxs-printer'></i></button>
                            </td>
                        </tr>
                        <tr v-if="lists.length == 0">
                            <td class="text-center" colspan="5">
                                No application found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Show ref="view"/>
</template>
<script>
import Pagination from "@/Shared/Pagination.vue";
import Show from './Modals/Show.vue';
export default {
    components : { Show, Pagination },
    inject:['count3', 'heightProfile'],
    props: ['auth','dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            keyword: '',
            status: (this.auth.data.roles.some(role => role.name === 'Hr Head')) ? 55 : (this.auth.data.roles.some(role => role.name === 'Regional Director') ? 56 : ''),
            department: (this.auth.data.roles.some(role => role.name === 'Hr Head')) ? this.auth.data.department.id : '',
            editable: false
        }
    },

    created(){
        this.fetch();
    },

    watch: {
        datares: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    this.message(val.data);
                }
            },
        }
    },
    
    computed: {
        datares() {
            return this.$page.props.flash.datares;
        },
        statuses : function() {
            return this.dropdowns.filter(x => x.type === 'Leave');
        },
        departments : function() {
            return this.dropdowns.filter(x => x.type === 'Department');
        },
    },

    methods : {
        fetch(page_url){
            page_url = page_url || '/leave';
            axios.get(page_url,{
                params : {
                    search: 'lists',
                    count: this.count3,
                    head: this.auth.data.roles.some(role => role.name === 'Hr Head'),
                    director: this.auth.data.roles.some(role => role.name === 'Regional Director'),
                    status: this.status,
                    department: this.department
                }
            }).then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            }).catch(err => console.log(err));
        },

        view(list){
            this.$refs.view.set(list);
        },

        message(list){
            let index = this.lists.findIndex(u => u.id === list.id);
            this.lists.splice(index,1);
        },

        print(list){
            window.open(this.currentUrl + '/leave/'+list.id+'/edit');
        }
    }
}
</script>