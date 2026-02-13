(function () {
	const root = document.getElementById('pocketbooksync-settings');
	if (!root) {
		return;
	}

	const requestToken = document.querySelector('head').dataset.requesttoken;
	const basePath = OC.generateUrl('/apps/pocketbooksync');

	const fields = {
		baseUrl: root.querySelector('#pbs-base-url'),
		username: root.querySelector('#pbs-username'),
		password: root.querySelector('#pbs-password'),
		targetFolder: root.querySelector('#pbs-target-folder'),
		syncIntervalMin: root.querySelector('#pbs-sync-interval'),
	};
	const status = root.querySelector('#pbs-status');
	const lastSync = root.querySelector('#pbs-last-sync');

	async function api(path, method, body) {
		const response = await fetch(basePath + path, {
			method,
			headers: {
				'Content-Type': 'application/json',
				requesttoken: requestToken,
			},
			body: body ? JSON.stringify(body) : undefined,
		});
		const payload = await response.json();
		if (!response.ok) {
			throw new Error(payload.error || 'Request failed');
		}
		return payload;
	}

	function fillForm(data) {
		fields.baseUrl.value = data.baseUrl || '';
		fields.username.value = data.username || '';
		fields.password.value = data.password || '';
		fields.targetFolder.value = data.targetFolder || '/PocketBook Highlights';
		fields.syncIntervalMin.value = data.syncIntervalMin || 60;
		status.textContent = 'Status: ' + (data.lastStatus || 'Never synced');
		if (data.lastSync) {
			lastSync.textContent = 'Last sync: ' + new Date(parseInt(data.lastSync, 10) * 1000).toLocaleString();
		}
	}

	function collect() {
		return {
			baseUrl: fields.baseUrl.value,
			username: fields.username.value,
			password: fields.password.value,
			targetFolder: fields.targetFolder.value,
			syncIntervalMin: parseInt(fields.syncIntervalMin.value, 10) || 60,
		};
	}

	root.querySelector('#pbs-save').addEventListener('click', async () => {
		await api('/settings', 'POST', collect());
		status.textContent = 'Status: settings saved';
	});

	root.querySelector('#pbs-test').addEventListener('click', async () => {
		status.textContent = 'Status: testing connection...';
		try {
			const result = await api('/settings/test-connection', 'POST');
			status.textContent = result.ok ? 'Status: connection OK' : 'Status: connection failed';
		} catch (e) {
			status.textContent = 'Status: connection failed (' + e.message + ')';
		}
	});

	root.querySelector('#pbs-sync').addEventListener('click', async () => {
		status.textContent = 'Status: syncing...';
		try {
			const result = await api('/settings/sync-now', 'POST');
			status.textContent = `Status: synced ${result.result.files} files`;
			lastSync.textContent = 'Last sync: ' + new Date().toLocaleString();
		} catch (e) {
			status.textContent = 'Status: sync failed (' + e.message + ')';
		}
	});

	api('/settings', 'GET').then(fillForm).catch((e) => {
		status.textContent = 'Status: failed to load settings (' + e.message + ')';
	});
})();
