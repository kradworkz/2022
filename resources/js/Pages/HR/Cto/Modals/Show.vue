
<template>
    <b-modal v-model="showModal" size="lg" title="Show CTO Application" centered>

        <div class="card-body border-bottom">
            <div class="d-flex mt-n3">
                <img v-if="user.profile.avatar" class="rounded-circle" :src="currentUrl+'/images/avatars/'+user.profile.avatar" alt="" height="40">
                <div class="flex-grow-1 ms-3">
                    <h6 class="fw-semibold">{{ user.profile.name }}</h6>
                    <ul class="list-unstyled hstack gap-2 mt-n1 mb-0 font-size-11">
                        <li>
                            <i class="bx bx-user-voice"></i> <span class="text-muted">{{ user.profile.position }}</span>
                        </li>
                        <li>
                            <i class="bx bx-map"></i> <span class="text-muted">{{ user.profile.office }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table font-size-12">
                        <tbody>
                            <tr>
                                <th scope="col">Date:</th>
                                <td scope="col">{{ user.date }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Purpose:</th>
                                <td>{{ user.purpose }}</td>
                            </tr>
                             <tr v-if="user.status.name == 'Approved' || user.status.name == 'Confirmed'">
                                <th scope="row">Total Hrs:</th>
                                <td>{{ toHoursAndMinutes() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered align-middle table-nowrap mb-0">
                        <tbody>
                            <tr class="text-center" v-for="(list,index) in user.dtrs" v-bind:key="index" :class="list.bg">
                                <td width="20%" class="text-start"><span class="text-body fw-bold">{{ list.date }}</span> <span class="text-muted font-size-11 ms-1">({{list.day}})</span></td>
                                <td width="15%">{{ (list) ? list.am_in : '' }}</td>
                                <td width="15%">{{ (list) ? list.am_out : '' }}</td>
                                <td width="15%">{{ (list) ? list.pm_in : '' }}</td>
                                <td width="15%">{{ (list) ? list.pm_out : '' }}</td>
                                <th width="10%" style="font-size: 9px;">{{ (list.tardiness != 0) ? list.tardiness+' minutes' : '-' }}</th>
                                <th width="10%" style="font-size: 9px;">{{ (list.undertime != 0) ? list.undertime+' minutes' : '-' }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <template v-slot:footer>
            <b-button @click="hide()" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Staff')" variant="secondary" block>Cancel</b-button>
            <b-button @click="save(59,user.id)" variant="success" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Staff') && user.status.name == 'Approved'" block>Confirm</b-button>
            <b-button @click="save(56,user.id)" variant="primary" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Head') && status == false" block>Recommend</b-button>
            <b-button @click="save('disapprove',user.id)" variant="danger" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Head' || role.name === 'Regional Director') && status == false" block>Disapprove</b-button>
            <b-button @click="save(57,user.id)" variant="success" v-if="$page.props.auth.data.roles.some(role => role.name === 'Regional Director') && status == false" block>Approve</b-button>
            <b-button @click="status = false" variant="light" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Head') && status == true" block>Cancel</b-button>
            <b-button @click="save(58,user.id)" variant="success" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Head') && status == true" block>Submit</b-button>
        </template>
    </b-modal>
</template>

<script>
    import Multiselect from '@suadelabs/vue3-multiselect';
    export default {
        components : { Multiselect },
        props: ['roles'],
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                user: {
                    profile : {},
                    type: {},
                    detail: {},
                    status: {},
                    dtrs: []
                },
                showModal: false,
                status: false,
                due: '',
                time: '00:00:00'
            }
        },

        methods: {
            set(user) {
                this.user = user;
                this.showModal = true;
            },

            save(status,id){
                if(status == 'disapprove'){
                    this.status = true;
                }else{
                    this.form = this.$inertia.form({
                        id: id,
                        status_id: status,
                        // due: this.due,
                        total: this.time
                    });

                    this.form.put('/cto/update',{
                        preserveScroll: true,
                        onSuccess: (response) => {
                            this.hide();
                        }
                    });
                }
            },

            hide(){
                this.showModal = false;
            },

            toHoursAndMinutes() {
                const totalTardiness = this.user.dtrs.reduce((acc, item) => acc + item.tardiness, 0);
                const totalUndertime = this.user.dtrs.reduce((acc, item) => acc + item.undertime, 0);
                const l = this.user.dtrs.length;
                const total = (480-(totalTardiness+totalUndertime))*2;
                const hours = Math.floor(total / 60);
                const minutes = total % 60;
                this.time = hours+':'+minutes+':'+'00';
                return hours+' hours '+minutes+ ' minutes';
            }
        }
    }

</script>
