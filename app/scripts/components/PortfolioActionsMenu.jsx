import ActionsMenu from './ActionsMenu';

const PortfolioActionsMenu = props => {
  const { portfolioForm, weightInputInit, deleteButtonInit, dragHandleInit, rowInit } = props;
  const template = document.querySelector('#portfolio-row');
  const totals = portfolioForm.querySelector('.portfolio-totals');

  const addPosition = event => {
    const count = portfolioForm.querySelectorAll('.portfolio-position-row').length;
    const fragment = template.content.cloneNode(true);
    const row = fragment.querySelector('.portfolio-row');

    const positionSelect = row.querySelector('.portfolio-position select');
    const positionLabel = row.querySelector('.portfolio-position label');

    positionSelect.setAttribute('name', `position_${count + 1}`);
    positionLabel.setAttribute('for', `position_${count + 1}`);

    const weightInput = row.querySelector('.portfolio-weight input');
    const weightLabel = row.querySelector('.portfolio-weight label');

    weightInput.setAttribute('name', `weight_${count + 1}`);
    weightLabel.setAttribute('for', `weight_${count + 1}`);

    const deleteButton = row.querySelector('.position-delete');
    const dragHandle = row.querySelector('.drag-handle');

    deleteButtonInit(deleteButton);
    dragHandleInit(dragHandle);
    weightInputInit(weightInput);
    rowInit(row);

    totals.before(row);
  }

  return (
    <ActionsMenu>
      <button type="button" onClick={addPosition}>Add Position</button>
    </ActionsMenu>
  )
}

export default PortfolioActionsMenu
