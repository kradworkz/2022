<template>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center mt-n1 mb-n1">
                <ul class="list-unstyled hstack gap-3 mb-0 font-size-11 flex-grow-1">
                    <li class="fw-bold font-size-13">Morale Survey</li>
                </ul>
                <div class="hstack gap-2">
                    <div class="input-group input-group-sm">
                        <select v-model="month" @change="fetch()" class="form-select form-select-sm" style="width: 120px;">
                            <option value="June">June</option>
                            <option value="December">December</option>
                        </select>
                        <input type="text" class="form-control " placeholder="year" v-model="year" style="width: 60px;" @keyup="fetch()">
                        <label class="input-group-text">Month & Year</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }">
        </div>
    </div>
</template>
<script>
export default {
    inject:['count3', 'heightProfile'],
    data(){
        return {
            currentUrl: window.location.origin,
            year: new Date().getFullYear(),
            month: 'June'
        }
    },

    methods : {
        fetch(page_url){
            page_url = page_url || '/dtr';
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
    }
}
</script>