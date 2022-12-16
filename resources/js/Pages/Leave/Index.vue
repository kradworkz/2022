<template>
    <Header :title="title" :content="title" :items="items" />
    <div class="col-12 mt-n3">
        <div class="card">
            <div class="card-body" :style="{ height: height + 'px' }">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 d-inline-block">
                        <form class="d-inline-block ">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword">
                                    <i class='bx bx-search-alt search-icon'></i>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <ul class="list-inline user-chat-nav text-end mb-0 dropdown">
                            <Pagination v-if="meta" @fetch="fetch" :links="links" :pagination="meta"/>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap align-middle">
                        <thead class="thead-light">
                            <tr class="font-size-11">
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;" class="text-center">Date</th>
                                <th style="width: 15%;" class="text-center">Type</th>
                                <th style="width: 10%;" class="text-center">Detail</th>
                                <th style="width: 10%;" class="text-center">Status</th>
                                <th style="width: 10%;" class="text-center">Created At</th>
                                <th style="width: 5%;" class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in lists" v-bind:key="list.id">
                                <td>
                                    <h5 class="font-size-13 mb-0 text-dark">{{list.profile.name}}</h5>
                                    <p class="font-size-12 text-muted mb-0">{{list.profile.department}}</p>
                                </td>
                                <td class="text-center fw-bold">{{ list.start }} to {{ list.end }}</td>
                                <td class="text-center">{{ list.type.name }}</td>
                                <td class="text-center">{{ list.detail.name }}</td>
                                <td class="text-center">{{ list.status.name }}</td>
                                <td class="text-center">{{ list.created_at }}</td>
                                <td class="text-end">
                                    <a class="me-3 text-warning" @click="view(list)"><i class='bx bx-show' ></i></a>
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
        <View ref="view"/>
    </div>
</template>
<script>
import View from './Modals/View.vue';
import Header from "@/Shared/Header.vue";
import Pagination from "@/Shared/Pagination.vue";
export default {
    components : { Header, Pagination, View },
    inject:['count3', 'height'],
    data(){
        return {
            currentUrl: window.location.origin,
            title: "Leave Application",
            items: [
                {text: "Leave", href: "/",},
                {text: "Lists",active: true,},
            ],
            lists: [],
            meta: {},
            links: {},
            keyword: '',
            editable: false
        }
    },

    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        }
    },

    created(){
        this.fetch();
    },

    methods : {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),

        fetch(page_url){
            page_url = page_url || '/leave';
            axios.get(page_url,{
                params : {
                    keyword : this.keyword,
                    count: this.count3,
                    search: true
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


        message(list){
            let index = this.lists.findIndex(u => u.id === list.id);
            this.lists[index] = list;
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