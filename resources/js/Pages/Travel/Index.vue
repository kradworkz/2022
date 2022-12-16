<template>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center mt-n1 mb-n1">
                <ul class="list-unstyled hstack gap-3 mb-0 font-size-11 flex-grow-1">
                    <li class="fw-bold font-size-13">Travel Order</li>
                </ul>
                <div class="hstack gap-2">
                    <a @click="request($page.props.auth.data.id)" class="btn btn-sm btn-primary"><i class="bx bx-plus align-middle"></i> Request Travel Order</a>
                </div>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }">
        </div>
    </div>
     <Request :dropdowns="dropdowns" ref="request"/>
</template>
<script>
import Request from "./Modals/Request.vue";
export default {
    inject:['count3', 'heightProfile'],
    components : { Request },
    data(){
        return {
            currentUrl: window.location.origin,
            year: new Date().getFullYear(),
            month: 'June'
        }
    },

    methods : {
        fetch(page_url){
            page_url = page_url || '/travel';
            axios.get(page_url,{
                params : {
                    keyword : this.keyword,
                    month: this.month,
                    year: this.year,
                    search: 'solo'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.absent = response.data.absent;
                }
            })
            .catch(err => console.log(err));
        },

        request(id){
            this.$refs.request.set(id);
        },
    }
}
</script>