import '../../styles/modules/ActionMenu.css';

import { useState, useRef, useContext } from 'react';
import useOnClickOutside from './useOnClickOutside';
import { ActionMenuContext } from './ActionMenuContext';

const ActionMenu = props => {
  const ref = useRef();
  const [ hidden, setHidden ] = useState(true);
  const { children } = props;

  useOnClickOutside(ref, event => setHidden(true));

  const toggleMenu = event => {
    setHidden(!hidden);
  }

  const actionMenuContextValue = {
    handleSelect: toggleMenu
  };

  return (
    <div ref={ref} className="actions-menu">
      <button type="button" className="actions-button" onClick={toggleMenu}>
        <i className="material-icons">settings</i>
      </button>
      <ul className={`actions-menu-dropdown ${hidden ? 'dropdown-hidden' : null}`}>
        <ActionMenuContext.Provider value={actionMenuContextValue}>
          {children}
        </ActionMenuContext.Provider>
      </ul>
    </div>
  );
};

export default ActionMenu;
