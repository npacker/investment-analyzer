let dragged = null;

let dragged_weight_input = null;
let dragged_position_select = null;

let dragged_weight = null;
let dragged_position = null;

let last_dragenter = null;

let last_weight_input = null;
let last_position_select = null;

let last_weight = null;
let last_position = null;

const row_ondrop = event => {
  event.preventDefault();

  dragged = null;

  dragged_weight_input = null;
  dragged_position_select = null;

  dragged_weight = null;
  dragged_position = null;

  last_dragenter = null;

  last_weight_input = null;
  last_position_select = null;

  last_weight = null;
  last_position = null;
};

const row_ondragover = event => {
  event.preventDefault();
};

const row_ondragenter = event => {
  event.preventDefault();

  event.dataTransfer.dropEffect = 'move';

  let current_dragenter = event.target;

  while (!current_dragenter.classList.contains('portfolio-row')) {
    current_dragenter = current_dragenter.parentNode;
  }

  if (current_dragenter != last_dragenter) {
    const target_weight_input = current_dragenter.querySelector('.portfolio-weight input');
    const target_position_select = current_dragenter.querySelector('.portfolio-position select');

    const target_weight = target_weight_input.value;
    const target_position = target_position_select.selectedIndex;

    target_weight_input.value = dragged_weight;
    target_position_select.selectedIndex = dragged_position;

    if (current_dragenter != dragged) {
      dragged_weight_input.value = target_weight;
      dragged_position_select.selectedIndex = target_position;
    }

    if (last_dragenter != dragged) {
      last_weight_input.value = last_weight;
      last_position_select.selectedIndex = last_position;
    }

    last_weight = target_weight;
    last_position = target_position;

    last_weight_input = target_weight_input;
    last_position_select = target_position_select;

    last_dragenter = current_dragenter;
  }
}

const row_ondragend = event => {
  event.target.removeAttribute('draggable');
};

const row_ondragstart = event => {
  event.dataTransfer.effectAllowed = 'move';

  dragged = event.target;

  dragged_weight_input = dragged.querySelector('.portfolio-weight input');
  dragged_position_select = dragged.querySelector('.portfolio-position select');

  dragged_weight = dragged_weight_input.value;
  dragged_position = dragged_position_select.selectedIndex;

  last_dragenter = dragged;

  last_weight_input = dragged_weight_input;
  last_position_select = dragged_position_select;

  last_weight = dragged_weight;
  last_position = dragged_position;
};

const delete_button_onclick = event => {
  event.target.parentElement.parentElement.remove();
};

const drag_handle_onmousedown = event => {
  event.target.parentElement.parentElement.setAttribute('draggable', true);
};

const row_init = row => {
  row.ondragstart = row_ondragstart;
  row.ondragend = row_ondragend;
  row.ondragenter = row_ondragenter;
  row.ondragover = row_ondragover;
  row.ondrop = row_ondrop;
};

const delete_button_init = button => {
  button.onclick = delete_button_onclick;
};

const drag_handle_init = handle => {
  handle.onmousedown = drag_handle_onmousedown;
};

const template = document.querySelector('#portfolio-row');
const totals = document.querySelector('.portfolio-totals');
const add_button = document.querySelector('#add-position');

add_button.onclick = event => {
  const fragment = template.content.cloneNode(true);
  const row = fragment.querySelector('.portfolio-row');
  const delete_button = row.querySelector('.position-delete');
  const drag_handle = row.querySelector('.drag-handle');

  delete_button_init(delete_button);
  drag_handle_init(drag_handle);
  row_init(row);

  totals.before(row);
};

const delete_buttons = document.querySelectorAll('.position-delete');

delete_buttons.forEach(delete_button_init);

const drag_handles = document.querySelectorAll('.drag-handle');

drag_handles.forEach(drag_handle_init);

const rows = document.querySelectorAll('.portfolio-row');

rows.forEach(row_init);
