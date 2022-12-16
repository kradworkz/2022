
<template>
    <b-modal v-model="showModal" size="xl" title="Show Leave Application" centered>

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
                <div class="col-md-6">
                    <table class="table font-size-12">
                        <tbody>
                            <tr>
                                <th scope="col">Type of Leave:</th>
                                <td scope="col">{{ user.type.name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Details of Leave:</th>
                                <td>{{ user.detail.name }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Date:</th>
                                <td scope="col" v-if="user.start == user.end">{{ user.start }}</td>
                                <td scope="col" v-else>{{ user.start }} to {{ user.end }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Working Days:</th>
                                <td>{{ user.days }} day<span v-if="user.start != user.end">s</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered text-center font-size-12">
                        <tbody>
                           <tr>
                                <th style="width: 30%;"></th>
                                <td style="width: 30%;">Vacation Leave</td>
                                <td style="width: 30%;">Sick Leave</td>
                            </tr>
                              <tr>
                                <th scope="row">Total Earned </th>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Less this application </th>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Balance </th>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" v-if="status == true">
                    <label class="mb-0">For disapproval due to</label>
                    <textarea v-model="due" class="form-control" maxlength="225" rows="2" placeholder="due.."></textarea>
                </div>
            </div>

        </div>
        <template v-slot:footer>
            <b-button @click="hide()" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Staff')" variant="secondary" block>Cancel</b-button>
            <b-button @click="save(55,user.id)" variant="primary" v-if="$page.props.auth.data.roles.some(role => role.name === 'Hr Staff')" block>Validate</b-button>
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
                    detail: {}
                },
                showModal: false,
                status: false,
                due: ''
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
                        due: this.due
                    });

                    this.form.put('/leave/update',{
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
        }
    }

</script>
