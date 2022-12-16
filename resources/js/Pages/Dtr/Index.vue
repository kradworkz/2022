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
                                <th style="width: 15%;" class="text-center">Am In</th>
                                <th style="width: 15%;" class="text-center">Am Out</th>
                                <th style="width: 15%;" class="text-center">Am In</th>
                                <th style="width: 15%;" class="text-center">Am Out</th>
                                <th style="width: 5%;" class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in lists" v-bind:key="list.id">
                                <td>
                                    <h5 class="font-size-13 mb-0 text-dark">{{list.name}}</h5>
                                    <p class="font-size-12 text-muted mb-0">{{list.username}}</p>
                                </td>
                                <td class="text-center fw-bold">{{ list.date }}</td>
                                <td class="text-center">
                                    <h5 class="font-size-12 mb-0 text-dark">{{list.am_in}}</h5>
                                    <p class="font-size-12 text-muted mb-0 ">{{list.am_in_at.ip}}</p>
                                </td>
                                <td class="text-center">
                                    <h5 class="font-size-12 mb-0 text-dark">{{list.am_out}}</h5>
                                    <p class="font-size-12 text-muted mb-0 ">{{list.am_out_at.ip}}</p>
                                </td>
                                 <td class="text-center">
                                    <h5 class="font-size-12 mb-0 text-dark">{{list.pm_in}}</h5>
                                    <p class="font-size-12 text-muted mb-0 ">{{list.pm_in_at.ip}}</p>
                                </td>
                                 <td class="text-center">
                                    <h5 class="font-size-12 mb-0 text-dark">{{list.pm_out}}</h5>
                                    <p class="font-size-12 text-muted mb-0 ">{{list.pm_out_at.ip}}</p>
                                </td>
                                <td class="text-end">
                                    <button @click="print(list)" type="button" class="btn btn-info btn-sm waves-effect waves-light me-1">View</button>
                                    <button @click="view(list)" type="button" class="btn btn-info btn-sm waves-effect waves-light me-1">View</button>
                                    <button @click="update(list)" type="button" class="btn btn-warning btn-sm waves-effect waves-light">Update</button>
                                </td>
                            </tr>
                            <tr v-if="lists.length == 0">
                                <td class="text-center" colspan="5">
                                    No dtr found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Update @info="message" ref="update"/>
        <View  ref="view"/>
    </div>
</template>
<script>
import Update from './Modals/Update.vue';
import View from './Modals/View.vue';
import Header from "@/Shared/Header.vue";
import Pagination from "@/Shared/Pagination.vue";
export default {
    components : { Header, Pagination, Update, View },
    inject:['count3', 'height'],
    data(){
        return {
            currentUrl: window.location.origin,
            title: "Date Time Records",
            items: [
                {text: "Dtr", href: "/",},
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
        },
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
    },

    created(){
        this.fetch();
    },

    methods : {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),

        fetch(page_url){
            page_url = page_url || '/dtr';
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

        update(list){
            this.$refs.update.set(list);
            this.editable = true;
        },

        view(list){
            this.$refs.view.set(list);
        },

        message(list){
            let index = this.lists.findIndex(u => u.id === list.id);
            this.lists[index] = list;
        },
    }
}
</script>