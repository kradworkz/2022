<template>
    <div class="card">
        <a @click="leave($page.props.auth.data.id)"  class="btn btn-primary me-2"><i class="bx bx-plus align-middle"></i>File Leave</a>
    <Leave :dropdowns="dropdowns" ref="leave"/>
    </div>
</template>
<script>
import Leave from '../Home/Modals/Leave.vue';
export default {
    props: ['dropdowns'],
    components : { Leave },
    data(){
        return {
            currentUrl: window.location.origin,
            content: 'test'
        }
    },
    methods : {
        leave(id){
            this.$refs.leave.set(id);
        }
    }
}
</script>