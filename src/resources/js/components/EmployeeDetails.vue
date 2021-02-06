<template>
<div v-if="appctx" class="card">
	<div class="card-header">
		<div class="float-left">{{form.title}}</div>
	</div>
	<div class="card-body">
		<form v-if="form.item" action="javascript:void(0);">
			<div class="form-group mb-0"><label>Name/Identity</label></div>
			<div class="form-inline">
				<div class="form-group">
					<label class="sr-only">Name Prefix</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.name_prefix"
						:disabled="!form.ctrl.edit"
						title="Prefix (e.g. 'Mr.')" placeholder="Mr."
						size="5"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">First Name</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.first_name"
						:disabled="!form.ctrl.edit"
						title="First name" placeholder="John"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">Middle Initial</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.middle_initial"
						:disabled="!form.ctrl.edit"
						title="Middle initial" placeholder="F"
						size="1"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">Last Name</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.last_name"
						:disabled="!form.ctrl.edit"
						title="Last name" placeholder="Kennedy"
					>
				</div>
			</div>
			<div class="form-inline">
				<div class="form-group">
					<label class="sr-only">Date of Birth</label>
					<input type="date" class="form-control mb-2 mr-sm-2"
						v-model="form.item.date_of_birth"
						:disabled="!form.ctrl.edit"
						title="'Date of birth" placeholder="10/31/1974"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">Gender</label>
					<select class="form-control mb-2 mr-sm-2"
						v-model="form.item.gender"
						:disabled="!form.ctrl.edit"
						title="Gender">
						<option value=""></option>
						<option value="M">M</option>
						<option value="F">F</option>
					</select>
				</div>
				<div class="form-group">
					<label class="sr-only">Social Security #</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.ssn"
						:disabled="!form.ctrl.edit"
						title="Social Security # xxx-xx-xxxx"
						placeholder="123-45-6789"
					>
				</div>
			</div>
			<div class="form-group mb-0"><label>HR Data</label></div>
			<div class="form-inline">
				<div class="form-group">
					<label class="sr-only">Date of Joining</label>
					<input type="date" class="form-control mb-2 mr-sm-2"
						v-model="form.item.date_of_joining"
						:disabled="!form.ctrl.edit"
						title="Date of joining" placeholder="02/28/2005"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">Salary</label>
					<input type="number" class="form-control mb-2 mr-sm-2"
						v-model="form.item.salary"
						:disabled="!form.ctrl.edit"
						title="Salary" placeholder="120000"
					>
				</div>
			</div>
			<div class="form-group mb-0"><label>Address</label></div>
			<div class="form-inline">
				<div class="form-group">
					<label class="sr-only">City</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.city"
						:disabled="!form.ctrl.edit"
						title="City" placeholder="Pleasanton"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">City</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.state"
						:disabled="!form.ctrl.edit"
						title="State" placeholder="CA" size="2"
					>
				</div>
				<div class="form-group">
					<label class="sr-only">Zip</label>
					<input type="text" class="form-control mb-2 mr-sm-2"
						v-model="form.item.zip"
						:disabled="!form.ctrl.edit"
						title="Zip" placeholder="94566" size="5"
					>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control"
							v-model="form.item.email"
							:disabled="!form.ctrl.edit"
							title="Email" placeholder="jfk@example.com"
						>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Phone #</label>
						<input type="text" class="form-control"
							v-model="form.item.phone_no"
							:disabled="!form.ctrl.edit"
							title="Phone# xxx-xxx-xxxx"
							placeholder="844-332-3320"
						>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label>Father's Name</label>
						<input type="text" class="form-control"
							v-model="form.item.fathers_name"
							:disabled="!form.ctrl.edit"
						>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Mother's Name</label>
						<input type="text" class="form-control"
							v-model="form.item.mothers_name"
							:disabled="!form.ctrl.edit"
						>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label>Mother's Maiden Name</label>
						<input type="text" class="form-control"
							v-model="form.item.mothers_maiden_name"
							:disabled="!form.ctrl.edit"
						>
					</div>
				</div>
				<div class="col"></div>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<div class="float-right">
			<button type="button" class="btn btn-primary"
				v-if="form.ctrl.edit"
				@click="saveForm($event)"
				:disabled="form.ctrl.hold"
			>{{form.labels.save}}</button>
			<template v-else>
			<button type="button" class="btn btn-primary"
				v-if="mayEnterEditMode"
				@click="enterEditMode($event)"
			>Edit</button>
			<button type="button" class="btn btn-primary btn-danger"
				v-if="mayDeleteItem"
				@click="deleteItem($event)"
			>Delete</button>
			</template>
			<button type="button" class="btn" :class="cancelBtnClass"
				@click="cancelForm($event)"
				:disabled="form.ctrl.hold"
			>Cancel</button>
		</div>
	</div>
</div>
</template>

<script>
export default {
	props: {
		appctx: Object,
		mode: String,
		empid: Number,
	},

	data() {
		return {
			editor: false,
			form: {
				item: null,
				ctrl: {
					edit: true,
					hold: false,
				},
				labels: {
					save: 'Save',
				},
			},
		};
	},

	created() {
		this.editor = this.appctx ? this.appctx.isAdmin() : false;
	},

	mounted() {
		const item = {
			id: this.empid,
		};

		if (this.mode == 'create') {
			this.form.item = item;
			this.form.title = 'New Employee (SPA)';
			this.form.ctrl.edit = true;
			this.form.ctrl.hold = false;
			this.form.labels.save = 'Save';
		}
		else {
			this.form.title = 'Employee #' + item.id + ' (SPA)';
			this.form.ctrl.edit = (this.mode != 'view');
			this.form.ctrl.hold = true;
			this.form.labels.save = 'Update';

			const id = item.id;

			this.appctx.apiGet('employees/'+id, null, (result) => {
				if (!result.data)
					return;
				const data = result.data;
				if (data.id != id)
					return;
				this.form.item = jQuery.extend({}, data);
				this.form.ctrl.hold = false;
			});
		}
	},

	computed: {
		cancelBtnClass() {
			return this.form.ctrl.edit ? 'btn-secondary' : 'btn-primary';
		},
		mayDeleteItem() {
			return this.mayEnterEditMode;
		},
		mayEnterEditMode() {
			return !this.form.ctrl.edit && this.editor && !this.form.ctrl.hold;
		},
	},

	methods: {
		cancelForm(ev) {
			if (ev)
				jQuery(ev.target).blur();
			this.form.item = null;
			this.form.ctrl.hold = false;
			this.$router.go(-1);
		},
		deleteItem(ev) {
			if (ev)
				jQuery(ev.target).blur();
			if (!confirm('Delete employee?'))
				return;

			const id = this.form.item.id;
			this.form.ctrl.hold = true;
			promise = this.appctx.apiDelete('employees/'+id, null, resp => {
				alert(resp.deleted
					? 'Employee deleted.'
					: 'Failed to delete employee.'
				);
				this.cancelForm();
			}, err => {
				alert('Failed to delete employee.');
			}).then(() => {
				this.form.ctrl.hold = false;
			});
		},
		enterEditMode(ev) {
			if (ev)
				jQuery(ev.target).blur();
			this.form.ctrl.edit = true;
		},
		saveForm(ev) {
			if (ev)
				jQuery(ev.target).blur();

			let item = this.form.item;
			if (!item || !this.form.ctrl.edit)
				return;
			const updating = item.id ? true : false;

			const success = (result) => {
				if (!result.data)
					return;
				jQuery.extend(this.form.item, result.data);
				alert(updating ? 'Employee updated.' : 'Employee created.');
				this.cancelForm();
			};
			const failure = (error) => {
				alert(updating
					? 'Failed to update employee.'
					: 'Failed to create employee.'
				);
			};

			this.form.ctrl.hold = true;

			let promise;
			if (updating) {
				promise = this.appctx.apiPut('employees/' + item.id, {
					data: item,
				}, success, failure);
			}
			else {
				promise = this.appctx.apiPost('employees', {
					data: item,
				}, success, failure);
			}

			promise.then(() => {
				this.form.ctrl.hold = false;
			});
		},
	},
}
</script>

<!-- vim: set ts=4 noexpandtab fdm=marker syntax=html: ('zR' to unfold all) -->
