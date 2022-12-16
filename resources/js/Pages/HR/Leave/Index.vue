<template>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center mt-n1 mb-n1">
                <ul class="list-unstyled hstack gap-3 mb-0 font-size-11 flex-grow-1">
                    <li class="fw-bold font-size-13">Leaves</li>
                </ul>
                <div class="hstack gap-2">
                    <a @click="leave($page.props.auth.data.id)" class="btn btn-sm btn-primary"><i class="bx bx-plus align-middle"></i> Request Leave</a>
                </div>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }">
            <div class="table-responsive" data-simplebar :style="{ height: (heightProfile-90) + 'px' }">
                <table class="table table-centered table-nowrap align-middle">
                    <thead class="thead-light">
                        <tr class="font-size-11">
                            <th style="width: 20%;" class="text-left">Type</th>
                            <th style="width: 20%;" class="text-center">Date</th>
                            <th style="width: 20%;" class="text-center">Detail</th>
                            <th style="width: 15%;" class="text-center">Created At</th>
                            <th style="width: 20%;" class="text-center">Status</th>
                            <th style="width: 5%;" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="list in lists" v-bind:key="list.id">
                            <td class="text-left">{{ list.type.name }}</td>
                            <td class="text-center">{{ list.start }} to {{ list.end }}</td>
                            <td class="text-center">{{ list.detail.name }}</td>
                            <td class="text-center">{{ list.created_at }}</td>
                            <td class="text-center">
                                <span :class="'badge bg-'+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-end">
                                <a class="me-3 text-dark" @click="view(list)"><i class='bx bx-show' ></i></a>
                                <a class="text-info" @click="print(list)"><i class='bx bxs-printer'></i></a>
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
    <Leave :dropdowns="dropdowns" ref="leave"/>
    <View ref="view"/>
</template>
<script>
import Leave from './Modals/Leave.vue';
import View from './Modals/View.vue';
export default {
    inject:['count3', 'heightProfile'],
    props: ['dropdowns'],
    components: { Leave, View },
    data(){
        return {
            currentUrl: window.location.origin,
            year: new Date().getFullYear(),
            month: 'June',
            lists: []
        }
    },

    created(){
        this.fetch();
    },

    methods : {
        fetch(page_url){
            page_url = page_url || '/leave';
            axios.get(page_url,{
                params : {
                    search: 'lists',
                    type: 'solo',
                    count: this.count3
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                }
            })
            .catch(err => console.log(err));
        },

        leave(id){
            this.$refs.leave.set(id);
        },

        view(list){
            this.$refs.view.set(list);
        },

        print(list){
            window.open(this.currentUrl + '/leave/'+list.id+'/edit');
        }
    }
}
</script>