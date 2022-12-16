
<template>
    <b-modal v-model="showModal" size="xl" ok-title="ok" title="View Leave Application" centered>

        <div class="card-body border-bottom">
            <div class="d-flex">
                <img v-if="user.profile.avatar" class="rounded-circle" :src="currentUrl+'/images/avatars/'+user.profile.avatar" alt="" height="50">
                <div class="flex-grow-1 ms-3">
                    <h5 class="fw-semibold">{{ user.profile.name }}</h5>
                    <ul class="list-unstyled hstack gap-2 mb-0">
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
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table font-size-12">
                        <tbody>
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
                <div class="col-md-12" v-if="user.status.id == 58">
                    <label class="mb-0 text-secondary font-size-11">For disapproval due to</label>
                    <textarea v-model="user.due" class="form-control" rows="1" readonly></textarea>
                </div>
            </div>

        </div>
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
                    status: {}
                },
                showModal: false,
            }
        },

        methods: {
            set(user) {
                this.user = user;
                this.showModal = true;
            },
        }
    }

</script>
