<template>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center mt-n1 mb-n1">
                <ul class="list-unstyled hstack gap-3 mb-0 font-size-11 flex-grow-1">
                    <li class="fw-bold font-size-13">Morale Survey (HR)</li>
                </ul>
                <div class="hstack gap-2">
                    <div class="input-group input-group-sm">
                    <select v-model="month" @change="fetch()" class="form-select form-select-sm" style="width: 120px;">
                        <option value="5">June</option>
                        <option value="11">December</option>
                    </select>
                    <input type="text" class="form-control " placeholder="year" v-model="year" style="width: 60px;" @keyup="fetch()">
                    <label class="input-group-text">Month & Year</label>
                </div>
                    <!-- <button type="button" @click="generate($page.props.auth.data.id)" class="btn btn-primary btn-sm">Download DTR <i class="bx bx-download align-baseline ms-1"></i></button> -->
                    <button @click="generate($page.props.auth.data.id)" type="button" v-b-tooltip.hover title="Print DTR" class="btn btn-primary btn-sm"><i class="bx bx-printer align-baseline"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }" v-if="lists.length > 0">
            <table class="table table-bordered align-middle table-nowrap mb-0">
                <thead class="thead-light">
                    <tr class="text-center font-size-11"> 
                        <th width="20%">Date</th>
                        <th width="20%">Time In (am)</th>
                        <th width="20%">Time Out (am)</th>
                        <th width="20%">Time In (pm)</th>
                        <th width="20%">Time Out (pm)</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            <div class="table-responsive" data-simplebar :style="{ height: (heightProfile-90) + 'px' }">
                <table class="table table-bordered align-middle table-nowrap mb-0">
                    <tbody>
                        <tr class="text-center" v-for="(list,index) in lists" v-bind:key="index" :class="list.bg">
                            <td width="20%" class="text-start"><span class="text-body fw-bold">{{ list.date }}</span> <span class="text-muted font-size-11 ms-1">({{list.day}})</span></td>
                            <template v-if="!list.is_with">
                                <td width="80%" colspan="5" style="letter-spacing: 10px;">{{ list.data }}</td>
                            </template>
                            <template v-else>
                                <td width="20%">{{ (list.data) ? list.data.am_in : '' }}</td>
                                <td width="20%">{{ (list.data) ? list.data.am_out : '' }}</td>
                                <td width="20%">{{ (list.data) ? list.data.pm_in : '' }}</td>
                                <td width="20%">{{ (list.data) ? list.data.pm_out : '' }}</td>
                                <td>
                                    <button @click="update(list.data,index)" v-b-tooltip.hover title="Update DTR" type="button"  class="bg-light btn btn-sm me-1"><i class='bx text-warning bxs-info-circle'></i></button>
                                </td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body font-size-12" :style="{ height: heightProfile + 'px' }" v-else>
            <div class="alert alert-warning mt-4 text-center" role="alert">
                Search username in the search box
            </div>
        </div>
    </div>
    <Update @info="message" ref="update"/>
    <Generate ref="generate"/>
</template>
<script>
import Update from '../DTR/Modals/Update.vue';
import Generate from '../DTR/Modals/Dtr.vue';
export default {
    components : { Update, Generate },
    inject:['count3', 'heightProfile'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            calendars : [],
            keyword: '',
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            editable: false,
            today: '',
            absent: 0,
            index: ''
        }
    },
}
</script>