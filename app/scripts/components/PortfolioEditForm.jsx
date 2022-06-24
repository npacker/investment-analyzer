import '../../styles/modules/PortfolioEditForm.css';

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

  const handleEqualizeWeights = event => {
    const count = positions.reduce((accumulator, current) => current.deleted ? accumulator : accumulator + 1, 0);
    const equalization = parseFloat((100. / count).toFixed(2));
    const deviation = parseFloat((equalization * count - 100.).toFixed(2));
    const correction = deviation < 0 ? .01 : -.01;
    const adjustments = parseInt(Math.abs(deviation) * 100.);

    let adjusted = 0;

    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      if (adjusted < adjustments && !prevPosition.deleted && ++adjusted) {
        return { ...prevPosition, weight: parseFloat((equalization + correction).toFixed(2)) };
      }
      else {
        return { ...prevPosition, weight: equalization };
      }
    }));
  };

  const handleNormalizeWeights = event => {
    const total = totalWeight();

    const percentages = positions.map(position => {
      const percentage = parseFloat((Math.floor(position.weight / total * 10000) / 100.).toFixed(2));
      return { ...position, weight: percentage };
    });

    const percentageTotal = parseFloat(percentages.reduce((accumulator, position) => {
      return position.deleted
        ? accumulator
        : accumulator + parseFloat(position.weight || 0.);
    }, 0.).toFixed(2));

    let deviation = parseFloat((100. - percentageTotal).toFixed(2));

    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      if (deviation && !prevPosition.deleted) {
        deviation -= .01
        return { ...prevPosition, weight: parseFloat((percentages[prevIndex].weight + .01).toFixed(2)) };
      }
      else {
        return { ...prevPosition, weight: percentages[prevIndex].weight };
      }
    }));
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
    setDraggable({ ...positions[index], index: index, currentTarget: event.currentTarget });
  };

  const handleDragEnd = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, draggable: false, dropzone: undefined }
        : { ...prevPosition, dropzone: undefined };
    }));
    setDraggable(null);
  };

  const handleDragEnter = (event, index) => {
    event.dataTransfer.dropEffect = 'move';
    const currentTarget = event.currentTarget;

    if (dragStack.length && !Object.is(currentTarget, dragStack[dragStack.length - 1])) {
      setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
        return index === prevIndex
          ? { ...prevPosition, dropzone: true }
          : { ...prevPosition, dropzone: undefined };
      }));
    }

    setDragStack(prevDragStack => prevDragStack.concat([currentTarget]));
  };

  const handleDragLeave = (event, index) => {
    setDragStack(prevDragStack => prevDragStack.slice(-1));
  };

  const handleDragOver = event => {
    event.preventDefault();
    event.dataTransfer.dropEffect = "move";
  };

  const handleDrop = (event, index) => {
    event.preventDefault();

    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      if (index === prevIndex) {
        return { ...prevPosition, symbol: draggable.symbol, weight: draggable.weight };
      }
      else if (draggable.index === prevIndex) {
        return { ...prevPosition, symbol: prevPositions[index].symbol, weight: prevPositions[index].weight };
      }
      else {
        return { ...prevPosition };
      }
    }));
  };

  const totalWeight = () => {
    return parseFloat(positions.reduce((total, position) => {
      return position.deleted
        ? total
        : total + parseFloat(position.weight || 0.0);
    }, 0.0).toFixed(2));
  };

  useEffect(() => {
    const portfolioForm = document.querySelector('.portfolio-form');
    portfolioForm.classList.add('fade-in');
  });

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
              className={`portfolio-row portfolio-position-row ${position.dropzone ? 'drop-zone' : ''}`}
              draggable={position.draggable}
              onDragStart={event => handleDragStart(event, index)}
              onDragEnd={event => handleDragEnd(event, index)}
              onDragEnter={event => handleDragEnter(event, index)}
              onDragLeave={event => handleDragLeave(event, index)}
              onDragOver={handleDragOver}
              onDrop={event => handleDrop(event, index)}
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
                  value={position.weight||''}
                  onChange={event => handleWeightChange(event, index)}
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
          <label htmlFor="total_weight" className="visually-hidden">
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
            <ActionMenuItem onClick={handleEqualizeWeights}>Equalize Weights</ActionMenuItem>
            <ActionMenuItem onClick={handleNormalizeWeights}>Normalize Weights</ActionMenuItem>
          </ActionMenu>
        </div>
      </div>
    </form>
  );
};

export default PortfolioEditForm;
