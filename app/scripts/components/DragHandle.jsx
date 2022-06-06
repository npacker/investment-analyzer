const DragHandle = props => {
  return (
    <button {...props} type="button" className="drag-handle">
      <i className="material-icons">
        drag_indicator
      </i>
    </button>
  );
};

export default DragHandle;
