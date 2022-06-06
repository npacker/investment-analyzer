import {
  useState,
  useEffect,
} from 'react';

import {
  ActionMenu,
  ActionMenuItem,
  DeleteButton,
  DragHandle,
  PositionWeightInput,
} from '../components';

const PortfolioEditForm = props => {
  const { name, funds } = props;

  const defaultPosition = {
    symbol: funds[0].symbol,
    weight: null,
    deleted: false,
    draggable: false,
  };

  const [ positions, setPositions ] = useState([{ ...defaultPosition }]);
  const [ draggable, setDraggable ] = useState(null);
  const [ draggedTo, setDraggedTo ] = useState(null);
  const [ dragStack, setDragStack ] = useState([]);

  const handlePositionChange = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, symbol: event.target.value }
        : { ...prevPosition };
    }));
  };

  const handleWeightChange = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, weight: event.target.value }
        : { ...prevPosition };
    }));
  };

  const handleDelete = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, deleted: true }
        : { ...prevPosition };
    }));
  };

  const handleAdd = event => {
    setPositions(prevPositions => prevPositions.concat([{ ...defaultPosition }]));
  };

  const handleNormalizeWeights = event => {
    return;
  };

  const handleDragHandleMouseDown = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, draggable: true }
        : { ...prevPosition };
    }));
  };

  const handleDragHandleMouseUp = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, draggable: false }
        : { ...prevPosition };
    }));
    setDraggable(null);
  };

  const handleDragStart = (event, index) => {
    event.dataTransfer.effectAllowed = 'move';
    const currentTarget = event.currentTarget;
    setDraggable({ ...positions[index], index: index, currentTarget: event.currentTarget });
  };

  const handleDragEnd = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, draggable: false }
        : { ...prevPosition };
    }));
    setDraggable(null);
  };

  const handleDragEnter = (event, index) => {
    event.dataTransfer.dropEffect = 'move';
    const currentTarget = event.currentTarget;
    setDragStack(prevDragStack => prevDragStack.concat([currentTarget]));

    if (!Object.is(currentTarget, dragStack[dragStack.length - 1]) && dragStack.length > 0) {
      setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
        return index === prevIndex
          ? { ...prevPosition, symbol: draggable.symbol, weight: draggable.weight }
          : { ...prevPosition };
      }));
    }
  };

  const handleDragLeave = (event, index) => {
    setDragStack(prevDragStack => prevDragStack.slice(-1));
  };

  const handleDragOver = event => {
    event.stopPropagation();
    event.preventDefault();
  };

  const handleDrop = event => {
    event.preventDefault();
  };

  const totalWeight = () => {
    return parseFloat(positions.reduce((total, position) => {
      return position.deleted
        ? total
        : total + parseFloat(position.weight || 0.0);
    }, 0.0).toFixed(2)).toString();
  };

  return (
    <form className="portfolio-form"method="POST">
      <label htmlFor="name">
        Name
      </label>
      <input type="text" name="name" defaultValue={name} size="40" required />
      <div className="portfolio-row portfolio-headers">
        <div className="portfolio-header">
          Position
        </div>
        <div className="portfolio-header">
          Weight
        </div>
      </div>
      {positions.map((position, index) => {
        if (position.deleted === false) {
          return (
            <div
              key={index}
              className="portfolio-row portfolio-position-row"
              draggable={position.draggable}
              onDragStart={event => handleDragStart(event, index)}
              onDragEnd={event => handleDragEnd(event, index)}
              onDragEnter={event => handleDragEnter(event, index)}
              onDragLeave={event => handleDragLeave(event, index)}
              onDragOver={handleDragOver}
              onDrop={handleDrop}
            >
              <DragHandle
                onMouseDown={event => handleDragHandleMouseDown(event, index)}
                onMouseUp={event => handleDragHandleMouseUp(event, index)}
              />
              <div className="portfolio-position">
                <label htmlFor={`positions[${index}][symbol]`} className="visually-hidden">
                  Position {index}
                </label>
                <select
                  name={`positions[${index}][symbol]`}
                  onChange={event => handlePositionChange(event, index)}
                  value={position.symbol}
                >
                  {funds.map(fund =>
                    <option key={fund.symbol} value={fund.symbol}>
                      {fund.name}
                    </option>
                  )}
                </select>
              </div>
              <div className="portfolio-weight">
                <label htmlFor={`positions[${index}][weight]`} className="visually-hidden">
                  Allocation for Position {index}
                </label>
                <PositionWeightInput
                  name={`positions[${index}][weight]`}
                  onChange={event => handleWeightChange(event, index)}
                  value={position.weight||''}
                />
              </div>
              <DeleteButton onClick={event => handleDelete(event, index)} />
            </div>
          );
        }
      })}
      <div className="portfolio-row portfolio-totals">
        <DragHandle disabled />
        <div className="portfolio-position">
        </div>
        <div className="portfolio-weight">
          <label className="visually-hidden" htmlFor="total_weight">
            Total
          </label>
          <PositionWeightInput name="total_weight" value={totalWeight()} readOnly />
        </div>
        <DeleteButton disabled />
      </div>
      <div className="form-actions">
        <input type="submit" value="Submit" />
        <div className="portfolio-actions">
          <ActionMenu>
            <ActionMenuItem onClick={handleAdd}>Add Position</ActionMenuItem>
            <ActionMenuItem onClick={handleNormalizeWeights}>Normalize Weights</ActionMenuItem>
          </ActionMenu>
        </div>
      </div>
    </form>
  );
};

export default PortfolioEditForm;
