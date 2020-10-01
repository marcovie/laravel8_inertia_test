<template>
    <div class="col-md-12">
        <button class="btn btn-sm btn-primary" @click="openModal()">Add New</button>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <td>Expense name</td>
                    <td>Amount</td>
                    <td>Date of purchase</td>
                    <td>Budget month</td>
                    <td>Description</td>
                    <td>&nbsp;</td>
                </tr>
            </thead>
            <tr v-for="row in data.data">
                <td>{{row.expense_name}}</td>
                <td>£ {{ row.amount }}</td>
                <td>{{ row.date_of_purchase }}</td>
                <td>{{ row.date_purchase_belongs_formated }}</td>
                <td>{{row.description}}</td>
                <td width="130">
                    <button @click="edit(row)" class="btn btn-sm btn-primary">Edit</button>
                    <button @click="deleteRow(row)" class="btn btn-sm btn-danger">Del</button>
                </td>
            </tr>
        </table>

        <div class="modal fade" id="modal">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Expense</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="expense_name">Expense name</label>
                            <input class="form-control" required id="expense_name" v-model="form.expense_name"/>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input class="form-control" required id="amount" v-model="form.amount"/>
                        </div>
                        <div class="form-group">
                            <label for="date_purchase_belongs">Budget month</label>
                            <input class="form-control" required id="date_purchase_belongs" v-model="form.date_purchase_belongs"/>
                        </div>
                        <div class="form-group">
                            <label for="date_of_purchase">Date of purchase</label>
                            <input class="form-control" required id="date_of_purchase" v-model="form.date_of_purchase"/>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input class="form-control" id="description" v-model="form.description"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="closeModal()">Close</button>
                        <button type="submit" class="btn btn-primary" v-show="!editMode" @click="save(form)">Save
                        </button>
                        <button type="submit" class="btn btn-primary" v-show="editMode" @click="update(form)">Update
                        </button>
                    </div>
                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            editMode: false,
            form: {
                expense_name: null,
                amount: null,
                date_purchase_belongs: null,
                date_of_purchase: null,
                description: null,
            },
        }
    },
    methods: {
        openModal: function () {
            $('#modal').modal('show')
        },
        closeModal: function () {
            $('#modal').modal('hide')
            this.reset();
            this.editMode=false;
        },
        reset: function () {
            this.form = {
                name: null,
                phone: null,
            }
        },
        save: function (data) {
            this.$inertia.post('/expense', data)
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            if (!confirm('Sure')) return;
            data._method = 'PUT';
            this.$inertia.post('/expense/' + data.id, data)
            this.reset();
            this.closeModal();
        },
        deleteRow: function (data) {
            if (!confirm('Sure')) return;
            data._method = 'DELETE';
            this.$inertia.post('/expense/' + data.id, data)
            this.reset();
            this.closeModal();
        },
        convertDate(date_to_convert, include, month_only) {
            let now = new Date(date_to_convert);

            if(now == "Invalid Date")
                return "-";

            let year = "" + now.getFullYear();
            let month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
            let monthName = "" + now.toLocaleString('default', { month: 'long' });
            let day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
            let hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
            let minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
            let second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }

            if(month_only)
            {
                return monthName;
            }
            else {
                if (include)
                    return day + "-" + month + "-" + year + " " + hour + ":" + minute + ":" + second;
                else
                    return day + "-" + month + "-" + year;
            }
        },
    }
}
</script>
