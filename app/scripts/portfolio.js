let dragged;

const row_ondrop = event => {
  event.preventDefault();

  let candidate = event.target;

  while (!candidate.classList.contains('portfolio-row')) {
    candidate = candidate.parentNode;
  }

  const target_weight_input = candidate.querySelector('.portfolio-weight input');
  const target_weight = target_weight_input.value;
  const dragged_weight_input = dragged.querySelector('.portfolio-weight input');

  target_weight_input.value = dragged_weight_input.value;
  dragged_weight_input.value = target_weight;

  const target_position_select = candidate.querySelector('.portfolio-position select');
  const target_position = target_position_select.selectedIndex;
  const dragged_position_select = dragged.querySelector('.portfolio-position select');

  target_position_select.selectedIndex = dragged_position_select.selectedIndex;
  dragged_position_select.selectedIndex = target_position;

  dragged = null;
};

const row_ondragover = event => {
  event.preventDefault();

  event.dataTransfer.dropEffect = 'move';
};

const row_ondragstart = event => {
  event.dataTransfer.effectAllowed = 'move';
  dragged = event.target;
};

const row_ondragend = event => {
  event.target.removeAttribute('draggable');
};

const row_init = row => {
  row.ondragstart = row_ondragstart;
  row.ondrop = row_ondrop;
  row.ondragover = row_ondragover;
  row.ondragend = row_ondragend;
};

const delete_button_onclick = event => {
  event.target.parentElement.parentElement.remove();
};

const drag_handle_onmousedown = event => {
  event.target.parentElement.parentElement.setAttribute('draggable', true);
};

const template = document.querySelector('#portfolio-row');
const form = document.querySelector('.portfolio-form');
const rows = document.querySelectorAll('.portfolio-row');
const totals = document.querySelector('.portfolio-totals');
const add_button = document.querySelector('#add-position');
const delete_buttons = document.querySelectorAll('.position-delete');
const drag_handles = document.querySelectorAll('.drag-handle');

add_button.onclick = () => {
  const fragment = template.content.cloneNode(true);
  const row = fragment.querySelector('.portfolio-row');
  const delete_button = row.querySelector('.position-delete');
  const drag_handle = row.querySelector('.drag-handle');

  delete_button.onclick = delete_button_onclick;
  drag_handle.onmousedown = drag_handle_onmousedown;

  row_init(row);

  totals.before(row);
};

delete_buttons.forEach(b => {
  b.onclick = delete_button_onclick;
});

drag_handles.forEach(h => {
  h.onmousedown = drag_handle_onmousedown;
});

rows.forEach(row_init);
