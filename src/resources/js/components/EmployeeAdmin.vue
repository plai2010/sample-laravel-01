<template>
<!-- Display a list of employees, with pagination and filtering. -->
<div v-if="appctx" class="card">
	<div class="card-header">Employee Admin (SPA)</div>
	<div class="card-body">
		<!-- Pagination and other controls (e.g. adding new employee). -->
		<div class="table-responsive">
			<div class="float-left">
				<ul class="pagination">
					<li class="page-item">
						<a class="page-link" @click="goPgFirst"
						>|&laquo;</a>
					</li>
					<li class="page-item" :class="{disabled:noPgPrev}">
						<a class="page-link" @click="goPgPrev"
							:disabled="noPgPrev"
						>&lsaquo;</a>
					</li>
					<li class="page-item" :class="{disabled:noPgNext}">
						<a class="page-link" @click="goPgNext"
							:disabled="noPgNext"
						>&rsaquo;</a>
					</li>
				</ul>
			</div>
			<div class="float-right">
				<button v-if="!filter.hidden"
					type="button" class="btn btn-primary"
					@click="filtersApply($event)"
				>Apply</button>
				<button v-if="!filter.hidden"
					type="button" class="btn btn-primary"
					@click="filtersClear($event)"
				>Clear</button>
				<button type="button" class="btn" :class="filterButtonClass"
					@click="filtersToggle($event)"
				>Filters</button>
				<router-link :to="{path:'/employees/create'}" v-slot="sp">
					<button type="button" class="btn btn-primary"
						@click="sp.navigate"
						:disabled="!mayCreate"
					>Create</button>
				</router-link>
			</div>
		</div>

		<!-- List of employees after filter. -->
		<div class="table-responsive">
			<table class="table table-sm table-bordered">
				<tr :class="{collapse:filter.hidden}">
					<td></td>
					<td>
						<input type="text" class="form-control mb-2 mr-sm-2"
							v-model="filter.vars.last_name"
							@input.passive="onFilterChange"
						>
					</td>
					<td>
						<input type="text" class="form-control mb-2 mr-sm-2"
							v-model="filter.vars.first_name"
							@input.passive="onFilterChange"
						>
					</td>
				</tr>
				<tr>
					<th>
						Employee ID
					</th>
					<th>
						Last Name
						<template v-if="filter.terms.last_name">*</template>
					</th>
					<th>
						First Name
						<template v-if="filter.terms.first_name">*</template>
					</th>
				</tr>
				<tr v-for="item in collection" :key="item.id">
					<td>
						<router-link
							:to="{ path: '/employees/'+item.id }"
						>{{item.id}}</router-link>
					</td>
					<td>{{item.last_name}}</td>
					<td>{{item.first_name}}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</template>

<script>
export default {
	/**
 	* Component's properties.
 	*/
	props: {
		appctx: Object,
	},

	data() {
		return {
			collection: [],
			editor: false,
			filter: {
				dirty: false,
				hidden: true,
				terms: {},
				vars: {},
			},
			pg: null,
			seq: 0,
		};
	},

	created() {
		this.filter.vars.first_name = null;
		this.filter.vars.last_name = null;
		this.editor = this.appctx ? this.appctx.isAdmin() : false;
	},

	mounted() {
		this.goPgFirst();
	},

	computed: {
		filterButtonClass() {
			return this.filter.hidden ? 'btn-primary' : 'btn-secondary';
		},
		mayCreate() {
			return this.editor && this.filter.hidden;
		},
		noPgNext() {
			return !this.pg || !this.pg.nx;
		},
		noPgPrev() {
			return !this.pg || !this.pg.pv;
		},
	},

	methods: {
		filtersApply(ev) {
			if (ev)
				jQuery(ev.target).blur();

			if (!this.filter.dirty)
				return;

			const vars = this.filter.vars;
			const terms = this.filter.terms;
			let n;
			for (n in vars) {
				if (vars[n] && vars[n].trim() != '')
					terms[n] = vars[n];
				else if (terms[n])
					delete terms[n];
			}

			this.filter.dirty = false;
			this.goPgFirst();
		},
		filtersClear(ev) {
			if (ev)
				jQuery(ev.target).blur();
			const vars = this.filter.vars;
			let cleared = 0;
			let n;
			for (n in this.filter.vars) {
				if (vars[n] && vars[n].trim() != '') {
					vars[n] = null;
					++cleared;
				}
			}
			if (cleared > 0)
				this.filter.dirty = true;
		},
		filtersToggle(ev) {
			if (ev)
				jQuery(ev.target).blur();

			if (this.filter.hidden) {
				const vars = this.filter.vars;
				const terms = this.filter.terms;
				let n;
				for (n in vars)
					vars[n] = terms[n] ? terms[n] : null;
			}

			this.filter.hidden = !this.filter.hidden;
		},
		goPgFirst() {
			this.loadPage(1);
		},
		goPgNext() {
			this.loadPage(this.pg.page + 1);
		},
		goPgPrev() {
			if (this.pg && this.pg.pv)
				this.loadPage(this.pg.page - 1);
			else
				this.goPgFirst();
		},
		loadPage(page) {
			page = page || this.pg.page;
			const seq = ++this.seq;
			const params = jQuery.extend({
				page: page,
			}, this.filter.terms);
			this.appctx.apiGet('employees', params, (result) => {
				if (this.seq != seq)
					return;
				this.collection = result.data;
				this.pg = {
					page: result.current_page,
					nx: result.next_page_url ? true : false,
					pv: result.prev_page_url ? true : false,
				};
			});
		},
		onFilterChange() {
			this.filter.dirty = true;
		},
	},
}
</script>

<!-- vim: set ts=4 noexpandtab fdm=marker syntax=html: ('zR' to unfold all) -->
