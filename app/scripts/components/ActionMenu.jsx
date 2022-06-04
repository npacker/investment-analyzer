import '../../styles/modules/ActionMenu.css';

import { useState, useRef } from 'react';
import useOnClickOutside from './useOnClickOutside';

const ActionMenu = props => {
  const ref = useRef();
  const [ hidden, setHidden ] = useState(true);
  const { children } = props;

  useOnClickOutside(ref, event => setHidden(true));

  const toggleMenu = event => {
    setHidden(!hidden);
  }

  return (
    <div ref={ref} className="actions-menu">
      <button type="button" className="actions-button" onClick={toggleMenu}>
        <i className="material-icons">settings</i>
      </button>
      <ul className={`actions-menu-dropdown ${hidden ? 'dropdown-hidden' : null}`}>
        { React.Children.map(children, child => <li className="actions-menu-item">{ child }</li>) }
      </ul>
    </div>
  );
};

export default ActionMenu;
