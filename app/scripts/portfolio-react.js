import * as ReactDOMClient from 'react-dom/client';
import { ActionMenu, ActionMenuItem, PortfolioEditForm } from './components';

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

function row_ondrop(event) {
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
}

function row_ondragover(event) {
  event.preventDefault();
}

function row_ondragenter(event) {
  event.preventDefault();

  event.dataTransfer.dropEffect = 'move';

  let current_dragenter = event.target;

  while ('classList' in current_dragenter && !current_dragenter.classList.contains('portfolio-position-row')) {
    current_dragenter = current_dragenter.parentNode;
  }

  if ('classList' in current_dragenter && current_dragenter.classList.contains('portfolio-position-row') && current_dragenter != last_dragenter) {
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

function row_ondragend(event) {
  event.target.removeAttribute('draggable');
}

function row_ondragstart(event) {
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
}

function delete_button_onclick(event) {
  event.target.parentElement.parentElement.remove();

  const rows = portfolio_form.querySelectorAll('.portfolio-position-row');

  rows.forEach((row, index) => {
    const position_select = row.querySelector('.portfolio-position select');
    const position_label = row.querySelector('.portfolio-position label');

    position_select.setAttribute('name', `position_${index + 1}`);
    position_label.setAttribute('for', `position_${index + 1}`);

    const weight_input = row.querySelector('.portfolio-weight input');
    const weight_label = row.querySelector('.portfolio-weight label');

    weight_input.setAttribute('name', `weight_${index + 1}`);
    weight_label.setAttribute('for', `weight_${index + 1}`);
  });
}

function drag_handle_onmousedown(event) {
  event.target.parentElement.parentElement.setAttribute('draggable', true);
}

function weight_input_onchange(event) {
  const input = event.target;

  input.value = parseFloat(parseFloat(input.value || 0.0).toFixed(2)).toString();

  const weight_inputs = portfolio_form.querySelectorAll('.portfolio-position-row .portfolio-weight input');

  let total_weight = 0.0;

  weight_inputs.forEach(input => {
    total_weight += parseFloat(input.value || 0.0);
  });

  weight_total_input.value = parseFloat(total_weight.toFixed(2)).toString();
}

function row_init(row) {
  row.ondragstart = row_ondragstart;
  row.ondragend = row_ondragend;
  row.ondragenter = row_ondragenter;
  row.ondragover = row_ondragover;
  row.ondrop = row_ondrop;
}

const portfolioFormContainer = document.getElementById('portfolio-form-react-container');
const portfolioFormRoot = ReactDOMClient.createRoot(portfolioFormContainer);

portfolioFormRoot.render(
  <PortfolioEditForm name={portfolio_name} funds={portfolio_funds} />
);
