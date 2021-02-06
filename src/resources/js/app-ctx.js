/**
 * Application context to hold access token.
 * Also some helper methods for API calls, etc.
 */
(function (global, factory) {
	if (typeof exports === 'object' && typeof module !== 'undefined')
		module.exports = factory(require('jquery'));
	else if (typeof define === 'function' && define.amd)
		define(['jquery'], factory);
	else {
		global = global || self;
		global.AppCtx = factory(global.jQuery);
	}
}(this, function($) {
	'use strict';

	return function(siteUrl, tokenUrl) {
		// Base URL of the site.
		Object.defineProperty(this, 'url', {
			value: siteUrl,
			writable: false,
		});

		// Access token and logged-in user.
		var accessToken = null;
		var user = null;

		// Context status: init => okay or init => fail*
		var status = 'init';

		// The resolve and reject callbacks from ready().
		var readyCallbacks = [];

		// Serializer for axios query string parameters.
		let PARAMS_SERIALIZER = (params) => $.param(params, false);

		//--------------------------------------------------------------
		// Internal helper functions.
		//--------------------------------------------------------------

		// Invoke API call.
		const invokeApi = (verb, path, params, payload, succ, fail) => {
			let req = {
				method: verb,
				url: this.url + '/api/' + path,
				headers: {
					Accept: 'application/json',
				},
			};

			// HTTP Bearer access token.
			if (accessToken && accessToken.token)
				req.headers.Authorization = 'Bearer ' + accessToken.token;

			if (params) {
				req.params = params;
				req.paramsSerializer = PARAMS_SERIALIZER;
			}
			if (payload) {
				req.data = payload;
			}

			let promise = axios(req);

			if (succ) {
				promise = promise.then(resp => {
					succ(resp.data, resp);
				});
			}

			return promise.catch(err => {
				console.error(err);
				if (fail)
					fail(err);
			});
		};

		const settleReady = (callbacks) => {
			// Invoke resolve() or reject() on callbacks depending on status.
			if (status == 'okay') {
				return callbacks.resolve(this);
			}
			else {
				const err = new Error('AppCtx bootstrap error: ' + status);
				return callbacks.reject(err);
			}
		};

		const setFinalStatus = sts => {
			status = sts;
			while (readyCallbacks.length > 0)
				settleReady(readyCallbacks.pop());
		};

		//--------------------------------------------------------------
		// Public functions.
		//--------------------------------------------------------------

		/** API call with DELETE method. */
		this.apiDelete = (path, params, succ, fail) => {
			return invokeApi('delete', path, params, null, succ, fail);
		};

		/** API call with GET method. */
		this.apiGet = (path, params, succ, fail) => {
			return invokeApi('get', path, params, null, succ, fail);
		};

		/** API call with POST method. */
		this.apiPost = (path, payload, succ, fail) => {
			return invokeApi('post', path, null, payload, succ, fail);
		};

		/** API call with PUT method. */
		this.apiPut = (path, payload, succ, fail) => {
			return invokeApi('put', path, null, payload, succ, fail);
		};

		/** Tell if user is admin. */
		this.isAdmin = () => (user || {}).admin ? true : false;

		/** Get promise of this app context becoming ready. */
		this.ready = () => {
			if (status == 'init') {
				return new Promise((resolve, reject) => {
					readyCallbacks.push({
						resolve: resolve,
						reject: reject,
					});
				});
			}
			else {
				return settleReady(Promise);
			}
		};

		//--------------------------------------------------------------
		// Bootstrap - get access token and then user.
		//--------------------------------------------------------------
		if (tokenUrl && tokenUrl != '') {
			axios({
				url: tokenUrl,
				withCredentials: true,
				headers: {
					Accept: 'application/json',
				},
			}).then(resp => {
				if (resp && resp.data && resp.data.access_token) {
					accessToken = resp.data.access_token;
				//	console.debug('Access token: '+JSON.stringify(accessToken));
					this.apiGet('user', null, (data) => {
						user = data;
					//	console.debug('User: '+JSON.stringify(user,null,'  '));
						setFinalStatus('okay');
					}, (err) => {
						console.error('Failed to get user: ' + err);
						setFinalStatus('fail.user');
					});
				}
				else {
					console.error('Malformed access token response: '
						+ JSON.stringify(resp, null, '  '));
					setFinalStatus('fail.access_token');
				}
			}).catch(err => {
				console.error('Failed to load access token: ' + err);
				setFinalStatus('fail.access_token');
			});
		}
		else {
			status = 'okay';
		}
	};
}));

// vim: set ts=4 noexpandtab fdm=marker syntax=javascript: ('zR' to unfold all)
