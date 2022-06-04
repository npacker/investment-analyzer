import { useContext } from 'react';
import { ActionMenuContext } from './ActionMenuContext';

const ActionMenuItem = props => {
  const { children, onClick } = props;
  const actionMenuContext = useContext(ActionMenuContext);

  const handleClick = event => {
    onClick(event);
    actionMenuContext.handleSelect(event);
  };

  return (
    <li className="actions-menu-item">
      <button type="button" onClick={handleClick}>
        {children}
      </button>
    </li>
  );
};

export default ActionMenuItem;
