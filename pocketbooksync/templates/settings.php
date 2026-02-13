<?php
script('pocketbooksync', 'settings');
?>
<div id="pocketbooksync-settings" class="section">
	<h2>PocketBook Sync</h2>
	<p>Configure your PocketBook Cloud credentials and sync target.</p>

	<div class="form-group">
		<label for="pbs-base-url">PocketBook Cloud URL</label>
		<input id="pbs-base-url" type="url" placeholder="https://cloud.pocketbook.digital" />
	</div>
	<div class="form-group">
		<label for="pbs-username">Email / Username</label>
		<input id="pbs-username" type="text" />
	</div>
	<div class="form-group">
		<label for="pbs-password">Password</label>
		<input id="pbs-password" type="password" />
	</div>
	<div class="form-group">
		<label for="pbs-target-folder">Target folder in your Nextcloud files</label>
		<input id="pbs-target-folder" type="text" placeholder="/PocketBook Highlights" />
	</div>
	<div class="form-group">
		<label for="pbs-sync-interval">Sync interval (minutes)</label>
		<input id="pbs-sync-interval" type="number" min="5" step="1" />
	</div>

	<div class="form-actions">
		<button id="pbs-save" class="primary">Save settings</button>
		<button id="pbs-test">Test connection</button>
		<button id="pbs-sync">Sync now</button>
	</div>

	<p id="pbs-status">Status: unknown</p>
	<p id="pbs-last-sync">Last sync: never</p>
</div>
