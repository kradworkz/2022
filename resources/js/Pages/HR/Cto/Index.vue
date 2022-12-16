<template>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center mt-n1 mb-n1">
                <ul class="list-unstyled hstack gap-3 mb-0 font-size-11 flex-grow-1">
                    <li class="fw-bold font-size-13">Compensatory Time Off</li>
                </ul>
                <div class="hstack gap-2">
                    <a @click="request($page.props.auth.data.id)" class="btn btn-sm btn-primary"><i class="bx bx-plus align-middle"></i> Request CTO</a>
                </div>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }">
            <div class="table-responsive" data-simplebar :style="{ height: (heightProfile-90) + 'px' }">
                <table class="table table-centered table-nowrap align-middle">
                    <thead class="thead-light">
                        <tr class="font-size-11">
                            <th style="width: 25%;" class="text-left">Name</th>
                            <th style="width: 25%;" class="text-center">Date</th>
                            <th style="width: 25%;" class="text-center">Created At</th>
                            <th style="width: 15%;" class="text-center">Status</th>
                            <th style="width: 10%;" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="list in lists" v-bind:key="list.id">
                            <td class="text-left">{{ list.profile.name }}</td>
                            <td class="text-center">{{ list.date }}</td>
                            <td class="text-center">{{ list.created_at }}</td>
                            <td class="text-center">
                                <span :class="'badge bg-'+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-end">
                                <button @click="view(list)" type="button" class="btn btn-light btn-sm w-md waves-effect waves-light">View</button>
                                <!-- <a class="me-3 text-dark" @click="view(list)"><i class='bx bx-show' ></i></a> -->
                                <!-- <button v-if="list.status.name == 'Approved'" @click="print(list)" type="button" class="btn btn-primary btn-sm ms-1 waves-effect waves-light"><i class='bx bxs-printer'></i></button> -->
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
    <Request :dropdowns="dropdowns" ref="request"/>
    <Show ref="view"/>
</template>
<script>
import Request from "./Modals/Request.vue";
import Show from './Modals/Show.vue';
export default {
    inject:['count3', 'heightProfile'],
    props: ['dropdowns'],
    components: { Request, Show },
    data(){
        return {
            currentUrl: window.location.origin,
            year: new Date().getFullYear(),
            month: 'June',
            lists: [],
            meta: {},
            links: {},
        }
    },

    created(){
        this.fetch();
    },

    methods : {
        fetch(page_url){
            page_url = page_url || '/cto';
            axios.get(page_url,{
                params : {
                    keyword : this.keyword,
                    month: this.month,
                    year: this.year,
                    search: 'lists',
                    type: 'solo'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },

        request(id){
            this.$refs.request.set(id);
        },

        view(list){
            this.$refs.view.set(list);
        },
    }
}
</script>