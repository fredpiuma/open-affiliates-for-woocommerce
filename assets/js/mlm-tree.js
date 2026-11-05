/*
 * Open Affiliates - MLM tree (local renderer, no external libraries).
 * Reads the .af-js-mlm-* data spans printed by the MLM views and draws a
 * collapsible organisation tree inside #af_mlm_chart.
 */
"use strict";
(function () {

	function attr(selector, name) {
		var el = document.querySelector(selector);
		return el ? (el.getAttribute(name) || '') : '';
	}

	function buildNode(node) {
		var li = document.createElement('li');
		var box = document.createElement('div');
		box.className = 'af-mlm-tree-node' + (node.cls ? ' ' + node.cls : '');
		if (node.tooltip) {
			box.setAttribute('title', node.tooltip);
		}

		var avatar = document.createElement('div');
		avatar.className = 'af-mlm-tree-avatar-child';
		var img = document.createElement('img');
		img.setAttribute('src', node.avatar);
		img.setAttribute('alt', '');
		avatar.appendChild(img);
		box.appendChild(avatar);

		var name = document.createElement('div');
		name.className = 'af-mlm-tree-name-child';
		name.textContent = node.name;
		box.appendChild(name);
		li.appendChild(box);

		if (node.children.length) {
			li.className = 'af-mlm-tree-has-children';
			box.addEventListener('click', function () {
				li.classList.toggle('af-mlm-tree-collapsed');
			});
			var ul = document.createElement('ul');
			node.children.forEach(function (child) {
				ul.appendChild(buildNode(child));
			});
			li.appendChild(ul);
		}
		return li;
	}

	function render() {
		var target = document.getElementById('af_mlm_chart');
		if (!target) {
			return;
		}
		var nodes = {};
		var order = [];

		var parentId = attr('.af-js-mlm-view-affiliate-children-parent-data', 'data-parent_id');
		var hasParent = attr('.af-js-mlm-view-affiliate-children-parent-data', 'data-parent');
		if (hasParent) {
			nodes[parentId] = {
				id: parentId, parentId: '', children: [], cls: 'af-mlm-tree-avatar-parent',
				avatar: attr('.af-js-mlm-view-affiliate-children-parent-data', 'data-parent_avatar'),
				name: attr('.af-js-mlm-view-affiliate-children-parent-data', 'data-parent_full_name'), tooltip: ''
			};
			order.push(parentId);
		}

		var mainId = attr('.af-js-mlm-view-affiliate-data', 'data-affiliate_id');
		nodes[mainId] = {
			id: mainId, parentId: parentId, children: [], cls: 'af-mlm-tree-avatar-main',
			avatar: attr('.af-js-mlm-view-affiliate-data', 'data-affiliate_avatar'),
			name: attr('.af-js-mlm-view-affiliate-data', 'data-parent_full_name'), tooltip: 'Main Affiliate'
		};
		order.push(mainId);

		document.querySelectorAll('.af-js-mlm-view-affiliate-children-data').forEach(function (el) {
			var id = el.getAttribute('data-id');
			nodes[id] = {
				id: id, parentId: el.getAttribute('data-parent_id') || '', children: [], cls: '',
				avatar: el.getAttribute('data-avatar') || '',
				name: el.getAttribute('data-full_name') || '', tooltip: el.getAttribute('data-amount') || ''
			};
			order.push(id);
		});

		var roots = [];
		order.forEach(function (id) {
			var n = nodes[id];
			if (n.parentId && nodes[n.parentId] && n.parentId !== id) {
				nodes[n.parentId].children.push(n);
			} else {
				roots.push(n);
			}
		});

		var ul = document.createElement('ul');
		roots.forEach(function (root) {
			ul.appendChild(buildNode(root));
		});
		var wrapper = document.createElement('div');
		wrapper.className = 'af-mlm-tree';
		wrapper.appendChild(ul);
		target.innerHTML = '';
		target.appendChild(wrapper);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', render);
	} else {
		render();
	}
})();
